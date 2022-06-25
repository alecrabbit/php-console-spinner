<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\MultiSpinner;
use AlecRabbit\Spinner\Spinner;

abstract class ASpinnerFactory implements ISpinnerFactory
{
    public static function create(?IConfig $config = null): ISpinner
    {
        $config = self::refineConfig($config);

        return new Spinner($config);
    }

    private static function refineConfig(?IConfig $config): IConfig
    {
        return $config ?? (new ConfigBuilder())->build();
    }

    public static function createMulti(IConfig $config = null): IMultiSpinner
    {
        $config = self::refineConfig($config);

        return new MultiSpinner($config);
    }
}
