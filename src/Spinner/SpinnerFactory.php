<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract;

final class SpinnerFactory implements Contract\ISpinnerFactory
{

    public static function create(string $class, ?Contract\ISpinnerConfig $config = null): Contract\ISpinner
    {
        $class = self::refineClass($class);
        $config = self::refineConfig($config);
        return new $class($config);
    }

    private static function refineClass(string $class): string
    {
        // TODO (2021-12-12 10:13) [Alec Rabbit]: implement refinement
        return $class;
    }

    private static function refineConfig(?Contract\ISpinnerConfig $config): Contract\ISpinnerConfig
    {
        if ($config instanceof Contract\ISpinnerConfig) {
            return $config;
        }
        return new SpinnerConfig();
    }
}
