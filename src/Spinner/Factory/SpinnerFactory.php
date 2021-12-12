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
        $spinner = new $class($config);

        self::attachToLoop($spinner, $config);

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

    private static function attachToLoop(Contract\ISpinner $spinner, Contract\ISpinnerConfig $config): void
    {
        $loop = $config->getLoop();
        if ($loop instanceof Contract\ILoop) {
            $loop->addPeriodicTimer(
                $spinner->interval(),
                static function () use ($spinner) {
                    $spinner->spin();
                }
            );
        }
    }
}
