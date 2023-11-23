<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Root\A\AFacade;
use AlecRabbit\Spinner\Root\Contract\IFacade;

final class Facade extends AFacade implements IFacade
{
    public static function getLoop(): ILoop
    {
        $loopProvider = self::getLoopProvider();

        if ($loopProvider->hasLoop()) {
            return $loopProvider->getLoop();
        }

        throw new DomainException('Event loop is unavailable.');
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $spinner = self::getSpinnerFactory()->create($spinnerSettings);

        if ($spinnerSettings?->isAutoAttach() ?? true) {
            self::getDriver()->add($spinner);
        }

        return $spinner;
    }

    public static function getDriver(): IDriver
    {
        return self::getDriverProvider()->getDriver();
    }

    public static function getSettings(): ISettings
    {
        return self::getSettingsProvider()->getUserSettings();
    }
}
