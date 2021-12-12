<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Contract;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Spinner;

final class SpinnerFactory implements Factory\Contract\ISpinnerFactory
{
    public static function create(?string $class = null, ?Contract\ISpinnerConfig $config = null): Contract\ISpinner
    {
        $class = self::refineClass($class);
        $config = self::refineConfig($config);

        $spinner =
            self::doCreate(
                $class,
                $config,
            );

        if ($spinner->isAsync()) {
            self::attachSpinnerToLoop($spinner, $config);
            self::initialize($spinner, $config);
            self::attachSigIntListener($spinner, $config);
        }

        return $spinner;
    }

    private static function refineClass(?string $class): string
    {
        // TODO (2021-12-12 10:13) [Alec Rabbit]: implement refinement
        return $class ?? Spinner::class;
    }

    private static function refineConfig(?Contract\ISpinnerConfig $config): Contract\ISpinnerConfig
    {
        if ($config instanceof Contract\ISpinnerConfig) {
            return $config;
        }
        return ConfigFactory::create();
    }

    private static function attachSpinnerToLoop(Contract\ISpinner $spinner, Contract\ISpinnerConfig $config): void
    {
        $config->getLoop()
            ->addPeriodicTimer(
                $spinner->interval(),
                static function () use ($spinner) {
                    $spinner->spin();
                }
            );
    }

    protected static function doCreate(string $class, Contract\ISpinnerConfig $config): Contract\ISpinner
    {
        if (is_subclass_of($class, Contract\ISpinner::class)) {
            return new $class($config);
        }
        throw new \RuntimeException(
            sprintf('Unsupported class [%s]', $class)
        );
    }

    private static function initialize(Contract\ISpinner $spinner, Contract\ISpinnerConfig $config): void
    {
        $spinner->begin();
    }

    private static function attachSigIntListener(Contract\ISpinner $spinner, Contract\ISpinnerConfig $config): void
    {
        if (\function_exists('pcntl_signal')) { // check for ext-pcntl
            $loop = $config->getLoop();
            /** @noinspection PhpComposerExtensionStubsInspection */
            $loop->addSignal(
                SIGINT,
                $func = static function () use ($loop, &$func, $spinner, $config) {
                    $spinner->erase();
                    $spinner->end();
                    $config->getOutput()->write(PHP_EOL . 'Ctrl+C to exit...' . PHP_EOL);
                    /** @noinspection PhpComposerExtensionStubsInspection */
                    $loop->removeSignal(SIGINT, $func);
                },
            );
        }
    }
}
