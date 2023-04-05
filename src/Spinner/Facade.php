<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;

final class Facade implements IFacade
{
    public static function createSpinner(IConfig $config = null): ISpinner
    {
        return
            self::getSpinnerFactory()
                ->createSpinner(
                    self::refineConfig($config)
                )
        ;
    }

    protected static function getSpinnerFactory(): ISpinnerFactory
    {
        return
            self::getContainer()
                ->get(ISpinnerFactory::class)
        ;
    }

    public static function getContainer(): IContainer
    {
        return ContainerFactory::getContainer();
    }

    protected static function refineConfig(?IConfig $config): IConfig
    {
        return
            $config ?? self::getConfigBuilder()->build();
    }

    public static function getConfigBuilder(): IConfigBuilder
    {
        return
            self::getContainer()
                ->get(IConfigBuilder::class)
        ;
    }

    public static function getLoop(): ILoopAdapter
    {
        return
            self::getContainer()
                ->get(ILoopFactory::class)
                ->getLoop()
        ;
    }
}
