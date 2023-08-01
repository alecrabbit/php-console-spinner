<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\A\AFacade;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

final class Facade extends AFacade
{
    public static function getLoop(): ILoop
    {
        return self::getLoopFactory()->getLoop();
    }

    private static function getLoopFactory(): ILoopFactory
    {
        return self::getContainer()->get(ILoopFactory::class);
    }


    public static function createSpinner(
        ILegacySpinnerConfig|ILegacyWidgetConfig|null $config = null,
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

    public static function getSettings(): ISettings
    {
        return
            self::getSettingsProvider()->getUserSettings();
    }

    protected static function getSettingsProvider(): ISettingsProvider
    {
        return self::getContainer()->get(ISettingsProvider::class);
    }

    protected static function getLegacySettingsProvider(): ILegacySettingsProvider
    {
        return self::getContainer()->get(ILegacySettingsProvider::class);
    }
}
