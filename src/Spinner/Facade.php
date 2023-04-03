<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;

final class Facade implements IFacade
{
    public static function createSpinner(IConfig $config = null): ISpinner
    {
        return
            self::getSpinnerFactory()->createSpinner($config);
    }

    /** @psalm-suppress MoreSpecificReturnType */
    protected static function getSpinnerFactory(): ISpinnerFactory
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    public static function getContainer(): IContainer
    {
        return ContainerFactory::getContainer();
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public static function getConfigBuilder(): IConfigBuilder
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return
            self::getContainer()->get(IConfigBuilder::class);
    }

    public static function getLoop(): ILoopAdapter
    {
        return
            self::getLoopFactory()->getLoop();
    }

    protected static function getLoopFactory(): ILoopFactory
    {
        return
            new LoopFactory(self::getLoopProbeFactory());
    }

    /** @psalm-suppress MoreSpecificReturnType */
    protected static function getLoopProbeFactory(): ILoopProbeFactory
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return self::getContainer()->get(ILoopProbeFactory::class);
    }
}
