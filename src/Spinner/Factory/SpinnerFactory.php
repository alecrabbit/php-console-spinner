<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Spinner;
use RuntimeException;

final class SpinnerFactory implements Factory\Contract\ISpinnerFactory
{
    private static ?Contract\ISpinner $spinner = null;

    public static function create(string|Contract\ISpinnerConfig|null $classOrConfig = null): Contract\ISpinner
    {
        if (self::$spinner instanceof Contract\ISpinner) {
            // there can be only one
            return self::$spinner;
        }


        $class = self::refineClass($classOrConfig);
        $config = self::refineConfig($classOrConfig);

        $spinner =
            self::doCreate(
                $class,
                $config,
            );

        if ($spinner->isAsynchronous()) {
            self::attachSpinnerToLoop($spinner, $config);
            self::initialize($spinner, $config);
            self::attachSigIntListener($spinner, $config);
        }

        return $spinner;
    }

    private static function refineClass(string|Contract\ISpinnerConfig|null $classOrConfig): string
    {
        if (is_string($classOrConfig)) {
            return $classOrConfig;
        }
        if($classOrConfig instanceof Contract\ISpinnerConfig) {
            return $classOrConfig->getSpinnerClass();
        }
        return Spinner::class;
    }

    private static function refineConfig(string|Contract\ISpinnerConfig|null $config): Contract\ISpinnerConfig
    {
        if ($config instanceof Contract\ISpinnerConfig) {
            return $config;
        }
        return (new ConfigBuilder())->build();
    }

    protected static function doCreate(string $class, Contract\ISpinnerConfig $config): Contract\ISpinner
    {
        if (is_subclass_of($class, Contract\ISpinner::class)) {
            return new $class($config);
        }
        throw new RuntimeException(
            sprintf('Unsupported class [%s]', $class)
        );
    }

    private static function attachSpinnerToLoop(
        Contract\ISpinner $spinner,
        Contract\ISpinnerConfig $config
    ): void {
        $config->getLoop()
            ->addPeriodicTimer(
                $spinner->interval(),
                static function () use ($spinner) {
                    $spinner->spin();
                }
            );
    }

    private static function initialize(
        Contract\ISpinner $spinner,
        Contract\ISpinnerConfig $config
    ): void {
        $spinner->begin();
    }

    private static function attachSigIntListener(
        Contract\ISpinner $spinner,
        Contract\ISpinnerConfig $config
    ): void {
        if (defined('SIGINT')) { // check for ext-pcntl
            $loop = $config->getLoop();
            /** @noinspection PhpComposerExtensionStubsInspection */
            $loop->addSignal(
                SIGINT,
                $func = static function () use ($loop, &$func, $spinner, $config) {
                    $spinner->erase();
                    $spinner->end();
                    $config->getOutput()->write(PHP_EOL . $config->getExitMessage() . PHP_EOL);
                    /** @noinspection PhpComposerExtensionStubsInspection */
                    $loop->removeSignal(SIGINT, $func);
                    $loop->addTimer(
                        $config->getShutdownDelay(),
                        static function () use ($loop) {
                            $loop->stop();
                        }
                    );
                },
            );
        }
    }

}
