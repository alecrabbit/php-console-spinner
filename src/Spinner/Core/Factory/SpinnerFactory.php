<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ILoop;
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
    public static function get(null|IFrameCollection|ISpinnerConfig $framesOrConfig = null): ISpinner
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
    public static function create(null|IFrameCollection|ISpinnerConfig $framesOrConfig = null): ISpinner
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
    private static function refineConfig(
        null|IFrameCollection|ISpinnerConfig $framesOrConfig
    ): ISpinnerConfig {
        if ($framesOrConfig instanceof ISpinnerConfig) {
            return $framesOrConfig;
        }

        return self::buildConfig($framesOrConfig);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function buildConfig(IFrameCollection|null $frames): ISpinnerConfig
    {
        $spinnerConfigBuilder = new SpinnerConfigBuilder();

        if ($frames instanceof IFrameCollection) {
            $spinnerConfigBuilder =
                $spinnerConfigBuilder
                    ->withFrames($frames)
            ;
        }

        return $spinnerConfigBuilder->build();
    }

    private static function asyncOperations(Spinner $spinner, ISpinnerConfig $config): void
    {
        if ($spinner->isAsynchronous()) {
            self::attachSpinnerToLoop($spinner, $config->getLoop());
            self::attachSigIntListener($spinner, $config);
            self::initialize($spinner);
        }
    }

    private static function attachSpinnerToLoop(ISpinner $spinner, ILoop $loop): void
    {
        $loop
            ->addPeriodicTimer(
                $spinner->refreshInterval()->toFloat(),
                static function () use ($spinner) {
                    $spinner->spin();
                }
            )
        ;
    }

    private static function attachSigIntListener(
        ISpinner $spinner,
        ISpinnerConfig $config,
    ): void {
        if (defined('SIGINT')) { // check for ext-pcntl
            $loop = $config->getLoop();

            $func = static function () use ($loop, &$func, $spinner, $config) {
                $spinner->end();
                $output = $config->getDriver()->getWriter()->getOutput();
                $output->write(PHP_EOL . $config->getExitMessage() . PHP_EOL);
                /** @noinspection PhpComposerExtensionStubsInspection */
                $loop->removeSignal(SIGINT, $func);
                $loop->addTimer(
                    $config->getShutdownDelay(),
                    static function () use ($loop, $config, $output) {
                        $loop->stop();
                        $output->write($config->getFinalMessage() . PHP_EOL);
                    }
                );
            };
            /** @noinspection PhpComposerExtensionStubsInspection */
            $loop->addSignal(SIGINT, $func,);
        }
    }

    private static function initialize(ISpinner $spinner): void
    {
        $spinner->begin();
    }

    private static function setSpinner(ISpinner $spinner): void
    {
        self::$spinner = $spinner;
    }
}
