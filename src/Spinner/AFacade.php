<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

abstract class AFacade extends AContainerEnclosure implements IFacade
{
    protected static function getSpinnerFactory(): ISpinnerFactory
    {
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    protected static function getLoopProvider(): ILoopProvider
    {
        return self::getContainer()->get(ILoopProvider::class);
    }

    protected static function getDriverProvider(): IDriverProvider
    {
        return self::getContainer()->get(IDriverProvider::class);
    }

    protected static function getSettingsProvider(): ISettingsProvider
    {
        return self::getContainer()->get(ISettingsProvider::class);
    }
}
