<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\MultiSpinner;
use AlecRabbit\Spinner\Spinner;

abstract class ASpinnerFactory implements ISpinnerFactory
{
    public static function create(?IConfig $config = null): ISpinner
    {
        return self::doCreate($config);
    }

    private static function refineConfig(?IConfig $config): IConfig
    {
        return $config ?? (new ConfigBuilder())->build();
    }

    public static function createMulti(IConfig $config = null): IMultiSpinner
    {
        return self::doCreate($config);
    }

    private static function doCreate(?IConfig $config): IBaseSpinner
    {
        $config = self::refineConfig($config);
        $type = $config->getType();
        return new $type($config);
    }
}
