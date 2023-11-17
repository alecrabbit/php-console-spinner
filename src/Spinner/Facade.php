<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Root\AFacade;

final class Facade extends AFacade
{
    public static function getLoop(): ILoop
    {
        $loopProvider = self::getLoopProvider();

        return
            $loopProvider->hasLoop()
                ? $loopProvider->getLoop()
                : throw new DomainException('Loop is unavailable.');
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $spinner =
            self::getSpinnerFactory()
                ->create($spinnerSettings)
        ;

        if ($spinnerSettings?->isAutoAttach() ?? true) {
            self::getDriver()
                ->add($spinner)
            ;
        }

        return $spinner;
    }

    public static function getDriver(): IDriver
    {
        return
            self::getDriverProvider()
                ->getDriver()
        ;
    }

    public static function getSettings(): ISettings
    {
        return
            self::getSettingsProvider()
                ->getUserSettings()
        ;
    }
}
