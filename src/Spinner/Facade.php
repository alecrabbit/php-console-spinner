<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Factory\ContainerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final class Facade implements IFacade
{
    public static function getLoop(): ILoop
    {
        return self::getLoopFactory()->getLoop();
    }

    protected static function getLoopFactory(): ILoopSingletonFactory
    {
        return self::getContainer()->get(ILoopSingletonFactory::class);
    }

    protected static function getContainer(): IContainer
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

    public static function getDriver(): IDriver
    {
        return self::getContainer()->get(IDriver::class);
    }
}
