<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class Facade implements IFacade
{
    public static function getLoop(): ILoop
    {
        return self::getLoopFactory()->getLoop();
    }

    private static function getLoopFactory(): ILoopFactory
    {
        return self::getContainer()->get(ILoopFactory::class);
    }

    private static function getContainer(): IContainer
    {
        $class = ContainerFactory::class;

        $registry = DefinitionRegistry::getInstance();

        return (new $class($registry))->getContainer();
    }

    public static function getSettingsProvider(): ISettingsProvider
    {
        return self::getContainer()->get(ISettingsProvider::class);
    }

    public static function createSpinner(
        ISpinnerConfig|IWidgetConfig|null $config = null,
        bool $attach = true
    ): ISpinner {
        $spinner =
            self::getSpinnerFactory()
                ->createSpinner($config)
        ;

        if ($attach) {
            self::attach($spinner);
        }

        return $spinner;
    }

    private static function getSpinnerFactory(): ISpinnerFactory
    {
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    protected static function attach(ISpinner $spinner): void
    {
        self::getDriverFactory()->getDriver()->add($spinner);
    }

    public static function getDriver(): IDriver
    {
        return self::getDriverFactory()->getDriver();
    }

    private static function getDriverFactory(): IDriverFactory
    {
        return self::getContainer()->get(IDriverFactory::class);
    }
}

//
