<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ISimpleSpinner;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\SimpleSpinner;

final class SpinnerFactory implements ISpinnerFactory
{
    private static ?ISimpleSpinner $spinner = null;

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public static function get(null|IFrameCollection|IConfig $framesOrConfig = null): ISimpleSpinner
    {
        if (self::hasSpinnerInstance()) {
            return self::$spinner;
        }
        return self::create($framesOrConfig);
    }

    private static function hasSpinnerInstance(): bool
    {
        return self::$spinner instanceof ISimpleSpinner;
    }

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public static function create(null|IFrameCollection|IConfig $framesOrConfig = null): ISimpleSpinner
    {
        if (self::hasSpinnerInstance()) {
            // There Can Be Only One
            throw new DomainException(
                sprintf('Spinner instance was already created: [%s]', self::$spinner::class)
            );
        }

        $config = self::refineConfig($framesOrConfig);

        $spinner = new SimpleSpinner($config);

        self::asyncOperations($spinner, $config);

        self::setSpinner($spinner);

        return $spinner;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function refineConfig(
        null|IFrameCollection|IConfig $framesOrConfig
    ): IConfig {
        if ($framesOrConfig instanceof IConfig) {
            return $framesOrConfig;
        }

        return self::buildConfig($framesOrConfig);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function buildConfig(IFrameCollection|null $frames): IConfig
    {
        $spinnerConfigBuilder = new ConfigBuilder();

        if ($frames instanceof IFrameCollection) {
            $spinnerConfigBuilder =
                $spinnerConfigBuilder
                    ->withFrames($frames)
            ;
        }

        return $spinnerConfigBuilder->build();
    }

    private static function asyncOperations(SimpleSpinner $spinner, IConfig $config): void
    {
        if ($config->isAsynchronous()) {
            self::attachSpinnerToLoop($spinner, $config->getLoop());
            self::attachSigIntHandler($spinner, $config);
            self::initialize($spinner);
        }
    }

    private static function attachSpinnerToLoop(ISimpleSpinner $spinner, ILoop $loop): void
    {
        $loop
            ->periodic(
                $spinner->getInterval()->toSeconds(),
                static function () use ($spinner) {
                    $spinner->spin();
                }
            )
        ;
    }

    private static function attachSigIntHandler(ISimpleSpinner $spinner, IConfig $config,): void
    {
        if (defined('SIGINT')) { // check for ext-pcntl
            $loop = $config->getLoop();
            $shutdownDelay = $config->getShutdownDelay();
            $func = static function () use ($spinner, $loop, $shutdownDelay, &$func) {
                $spinner->interrupt();
                /** @noinspection PhpComposerExtensionStubsInspection */
                $loop->removeHandler(SIGINT, $func);
                $loop->defer(
                    $shutdownDelay,
                    static function () use ($loop, $spinner) {
                        $loop->stop();
                        $spinner->finalize();
                    }
                );
            };
            /** @noinspection PhpComposerExtensionStubsInspection */
            $loop->addHandler(SIGINT, $func,);
        }
    }

    private static function initialize(ISimpleSpinner $spinner): void
    {
        $spinner->initialize();
    }

    private static function setSpinner(ISimpleSpinner $spinner): void
    {
        self::$spinner = $spinner;
    }
}
