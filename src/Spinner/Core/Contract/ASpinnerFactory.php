<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\MultiSpinner;
use AlecRabbit\Spinner\SimpleSpinner;

abstract class ASpinnerFactory implements ISpinnerFactory
{
    abstract public static function create(?IConfig $config = null): ISimpleSpinner|IMultiSpinner;

    protected static function createSpinner(IConfig $config): ISimpleSpinner
    {
        return new SimpleSpinner($config);
    }

    protected static function createMultiSpinner(IConfig $config): IMultiSpinner
    {
        return new MultiSpinner($config);
    }

    protected static function refineConfig(?IConfig $config): IConfig
    {
        return $config ?? (new ConfigBuilder())->build();
    }
}
