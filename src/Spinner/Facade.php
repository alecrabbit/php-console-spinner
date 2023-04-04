<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;

final class Facade implements IFacade
{
    public static function createSpinner(IConfig $config = null): ISpinner
    {
        $config = self::refineConfig($config);

        $spinner = self::getSpinnerFactory()->createSpinner($config);

        if ($config->getSpinnerConfig()->isEnabledInitialization()) {
            $spinner->initialize();
        }

        if ($config->getLoopConfig()->isAsynchronous() && $config->getSpinnerConfig()->isEnabledAttach()) {
            self::getSpinnerAttacher()->attach($spinner);
        }

        return
            $spinner;
    }

    protected static function refineConfig(?IConfig $config): IConfig
    {
        return $config ?? self::getConfigBuilder()->build();
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public static function getConfigBuilder(): IConfigBuilder
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return
            self::getContainer()->get(IConfigBuilder::class);
    }

    public static function getContainer(): IContainer
    {
        return ContainerFactory::getContainer();
    }

    /** @psalm-suppress MoreSpecificReturnType */
    protected static function getSpinnerFactory(): ISpinnerFactory
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    protected static function getSpinnerAttacher(): ISpinnerAttacher
    {
        return
            self::getContainer()
                ->get(ISpinnerAttacherFactory::class)
                ->getAttacher()
        ;
    }

    public static function getLoop(): ILoopAdapter
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return self::getContainer()->get(ILoopFactory::class)->getLoop();
    }
}
