<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\A\AContainerAware;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IFacade;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

final class Facade extends AContainerAware implements IFacade
{
    public static function createSpinner(IConfig $config = null): ISpinner
    {
        return
            self::getSpinnerFactory()->createSpinner($config);
    }

    protected static function getSpinnerFactory(): ISpinnerFactory
    {
        return self::getContainer()->get(ISpinnerFactory::class);
//        return new SpinnerFactory(self::getContainer());
    }

    public static function getConfigBuilder(): IConfigBuilder
    {
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
        $container = self::getContainer();
        return
            new LoopFactory(
                $container,
                $container->get(ILoopProbeFactory::class)
            );
    }
}
