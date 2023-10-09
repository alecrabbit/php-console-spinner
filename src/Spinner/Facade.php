<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;

final class Facade extends AContainerEnclosure
{
    private static ?IDriver $driver = null;

    public static function getLoop(): ILoop
    {
//        return self::getLoopProvider()->getLoop(); // TODO: Implement this.
        return self::getLoopFactory()->create();
    }

    private static function getLoopFactory(): ILoopFactory
    {
        return self::getContainer()->get(ILoopFactory::class);
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $spinnerFactory = self::getSpinnerFactory();

        $spinner = $spinnerFactory->create($spinnerSettings);

        if ($spinnerSettings?->isAutoAttach() ?? true) {
            self::getDriver()->add($spinner);
        }

        return $spinner;
    }

    private static function getSpinnerFactory(): ISpinnerFactory
    {
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    public static function getDriver(): IDriver
    {
        if (self::$driver === null) {
            self::$driver = self::getDriverFactory()->create();
        }
        return self::$driver;
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

}
