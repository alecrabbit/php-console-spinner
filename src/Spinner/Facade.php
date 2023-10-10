<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;

final class Facade extends AFacade
{
    public static function getLoop(): ILoop
    {
        return self::getLoopProvider()->getLoop();
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

    public static function getDriver(): IDriver
    {
        return self::getDriverProvider()->getDriver();
    }

    protected static function setupDriver(IDriver $driver): void
    {
        self::getDriverSetup()->setup($driver);
    }

    public static function getSettings(): ISettings
    {
        return
            self::getSettingsProvider()->getUserSettings();
    }

}
