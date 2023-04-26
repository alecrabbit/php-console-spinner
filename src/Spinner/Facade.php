<?php

declare(strict_types=1);

// 29.03.23

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Factory\ContainerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class Facade implements IFacade
{
    public static function getLoop(): ILoop
    {
        return self::getLoopFactory()->getLoop();
    }

    private static function getLoopFactory(): ILoopSingletonFactory
    {
        return self::getContainer()->get(ILoopSingletonFactory::class);
    }

    private static function getContainer(): IContainer
    {
        return ContainerSingletonFactory::getContainer();
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
        return self::getContainer()->get(IDefaultsProvider::class);
    }

    public static function createSpinner(?ISpinnerConfig $settings = null): ISpinner
    {
        $spinner =
            self::getSpinnerFactory()
                ->createSpinner($settings)
        ;

        $driver = self::getDriverFactory()
            ->getDriver()
        ;
        $driver->add($spinner);

        return $spinner;
    }

    private static function getSpinnerFactory(): ISpinnerFactory
    {
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    public static function getDriver(): IDriver
    {
        return self::getDriverFactory()->getDriver();
    }

    private static function getDriverFactory(): IDriverSingletonFactory
    {
        return self::getContainer()->get(IDriverSingletonFactory::class);
    }
}
