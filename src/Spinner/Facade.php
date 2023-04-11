<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Factory\ContainerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final class Facade implements IFacade
{
    public static function createSpinner(IConfig $config = null): ILegacySpinner
    {
        $config = self::refineConfig($config);

        $spinner = self::getSpinnerFactory()->createSpinner($config);

        self::getLoopSetup($config)->setup($spinner);

        return
            $spinner;
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

    protected static function getContainer(): IContainer
    {
        return ContainerSingletonFactory::getContainer();
    }

    protected static function getSpinnerFactory(): ILegacySpinnerFactory
    {
        return
            self::getContainer()
                ->get(ILegacySpinnerFactory::class)
        ;
    }

    protected static function getLoopSetup(IConfig $config): ILoopSetup
    {
        return
            self::getLoopFactory()
                ->getLoopSetup($config->getLoopConfig())
        ;
    }

    protected static function getLoopFactory(): ILoopFactory
    {
        return self::getContainer()
            ->get(ILoopFactory::class)
        ;
    }

    public static function getLoop(): ILoop
    {
        return
            self::getLoopFactory()
                ->getLoop()
        ;
    }

    public static function useService(string $id, object|callable|string $service): void
    {
        $container = self::getContainer();

        match ($container->has($id)) {
            true => $container->replace($id, $service),
            default => $container->add($id, $service),
        };
    }

    public static function getDefaultsProvider(): IDefaultsProvider
    {
        return
            self::getConfigBuilder()
                ->getDefaultsProvider();
    }
}
