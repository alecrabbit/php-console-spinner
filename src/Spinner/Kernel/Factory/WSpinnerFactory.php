<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Factory;

use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\ILoop;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\IWSimpleSpinner;
use AlecRabbit\Spinner\Kernel\Factory\Contract\IWSpinnerFactory;
use AlecRabbit\Spinner\WSimpleSpinner;

final class WSpinnerFactory implements IWSpinnerFactory
{
    private static ?IWSimpleSpinner $spinner = null;

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public static function get(null|IWFrameCollection|IConfig $framesOrConfig = null): IWSimpleSpinner
    {
        if (self::hasSpinnerInstance()) {
            return self::$spinner;
        }
        return self::create($framesOrConfig);
    }

    private static function hasSpinnerInstance(): bool
    {
        return self::$spinner instanceof IWSimpleSpinner;
    }

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public static function create(null|IWFrameCollection|IConfig $framesOrConfig = null): IWSimpleSpinner
    {
        if (self::hasSpinnerInstance()) {
            // There Can Be Only One
            throw new DomainException(
                sprintf('Spinner instance was already created: [%s]', self::$spinner::class)
            );
        }

        $config = self::refineConfig($framesOrConfig);

        $spinner = new WSimpleSpinner($config);

        self::asyncOperations($spinner, $config);

        self::setSpinner($spinner);

        return $spinner;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function refineConfig(
        null|IWFrameCollection|IConfig $framesOrConfig
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
    private static function buildConfig(IWFrameCollection|null $frames): IConfig
    {
        $spinnerConfigBuilder = new ConfigBuilder();

        if ($frames instanceof IWFrameCollection) {
            $spinnerConfigBuilder =
                $spinnerConfigBuilder
                    ->withFrames($frames)
            ;
        }

        return $spinnerConfigBuilder->build();
    }

    private static function asyncOperations(WSimpleSpinner $spinner, IConfig $config): void
    {
        if ($config->isAsynchronous()) {
            self::attachSpinnerToLoop($spinner, $config->getLoop());
            self::attachSigIntHandler($spinner, $config);
            self::initialize($spinner);
        }
    }

    private static function attachSpinnerToLoop(IWSimpleSpinner $spinner, ILoop $loop): void
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

    private static function attachSigIntHandler(IWSimpleSpinner $spinner, IConfig $config,): void
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

    private static function initialize(IWSimpleSpinner $spinner): void
    {
        $spinner->initialize();
    }

    private static function setSpinner(IWSimpleSpinner $spinner): void
    {
        self::$spinner = $spinner;
    }
}
