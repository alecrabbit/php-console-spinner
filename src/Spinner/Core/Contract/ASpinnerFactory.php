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
    protected static function createSpinner(IConfig $config): ISpinner
    {
        return new Spinner($config);
    }

    public static function create(?IConfig $config = null): ISpinner | IMultiSpinner
    {
        $config = $config ?? (new ConfigBuilder())->build();

        if ($config->forMultiSpinner()) {
            return static::createMultiSpinner($config);
        }

        return static::createSpinner($config);
    }

    protected static function createMultiSpinner(IConfig $config): IMultiSpinner
    {
        return new MultiSpinner($config);
    }
}
