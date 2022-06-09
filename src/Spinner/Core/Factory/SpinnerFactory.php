<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Spinner;

final class SpinnerFactory implements ISpinnerFactory
{
    private static ?ISpinner $spinner = null;

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public static function get(iterable|string|ISpinnerConfig|null $framesOrConfig = null): ISpinner
    {
        if (self::hasSpinnerInstance()) {
            return self::$spinner;
        }
        return self::create($framesOrConfig);
    }

    private static function hasSpinnerInstance(): bool
    {
        return self::$spinner instanceof ISpinner;
    }

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public static function create(iterable|string|ISpinnerConfig|null $framesOrConfig = null): ISpinner
    {
        if (self::hasSpinnerInstance()) {
            // There Can Be Only One
            throw new DomainException(
                sprintf('Spinner instance was already created: [%s]', self::$spinner::class)
            );
        }

        $config = self::refineConfig($framesOrConfig);

        $spinner = new Spinner($config);

        self::asyncOperations($spinner, $config);

        self::setSpinner($spinner);

        return $spinner;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function refineConfig(iterable|null|string|ISpinnerConfig $framesOrConfig): ISpinnerConfig
    {
        if ($framesOrConfig instanceof ISpinnerConfig) {
            return $framesOrConfig;
        }

        return self::buildConfig($framesOrConfig);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function buildConfig(IFrameContainer|iterable|string|null $framesOrConfig): ISpinnerConfig
    {
        $spinnerConfigBuilder = new SpinnerConfigBuilder();

        if (is_string($framesOrConfig) || is_iterable($framesOrConfig)) {
            $spinnerConfigBuilder = $spinnerConfigBuilder->withFrames($framesOrConfig);
        }

        return $spinnerConfigBuilder->build();
    }

    private static function asyncOperations(Spinner $spinner, ISpinnerConfig $config): void
    {
        if ($spinner->isAsynchronous()) {
            self::attachSpinnerToLoop($spinner, $config);
            self::attachSigIntListener($spinner, $config);
            self::initialize($spinner);
        }
    }

    private static function attachSpinnerToLoop(ISpinner $spinner, ISpinnerConfig $config): void
    {
        $config->getLoop()
            ->addPeriodicTimer(
                $spinner->refreshInterval()->toFloat(),
                static function () use ($spinner) {
                    $spinner->spin();
                }
            )
        ;
    }

    private static function initialize(ISpinner $spinner): void
    {
        $spinner->begin();
    }

    private static function attachSigIntListener(
        ISpinner $spinner,
        ISpinnerConfig $config,
    ): void {
        if (defined('SIGINT')) { // check for ext-pcntl
            $loop = $config->getLoop();

            $func = static function () use ($loop, &$func, $spinner, $config) {
                $spinner->end();
                $config->getDriver()->getWriter()->getOutput()->write(PHP_EOL . $config->getExitMessage() . PHP_EOL);
                /** @noinspection PhpComposerExtensionStubsInspection */
                $loop->removeSignal(SIGINT, $func);
                $loop->addTimer(
                    $config->getShutdownDelay(),
                    static function () use ($loop, $spinner) {
                        $loop->stop();
                        //dump($spinner);
                    }
                );
            };
            /** @noinspection PhpComposerExtensionStubsInspection */
            $loop->addSignal(SIGINT, $func,);
        }
    }

    private static function setSpinner(ISpinner $spinner): void
    {
        self::$spinner = $spinner;
    }
}
