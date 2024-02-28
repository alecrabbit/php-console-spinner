<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root\A;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class AFacade extends AContainerEnclosure
{
    public static function getLoop(): ILoop
    {
        $loopProvider = self::getLoopProvider();

        if ($loopProvider->hasLoop()) {
            return $loopProvider->getLoop();
        }

        throw new DomainException('Event-loop is unavailable.');
    }

    protected static function getLoopProvider(): ILoopProvider
    {
        return self::getContainer()->get(ILoopProvider::class);
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $spinner = self::getSpinnerFactory()->create($spinnerSettings);

        if ($spinnerSettings?->isAutoAttach() ?? true) {
            self::getDriver()->add($spinner);
        }

        return $spinner;
    }

    protected static function getSpinnerFactory(): ISpinnerFactory
    {
        return self::getContainer()->get(ISpinnerFactory::class);
    }

    public static function getDriver(): IDriver
    {
        return self::getDriverProvider()->getDriver();
    }

    protected static function getDriverProvider(): IDriverProvider
    {
        return self::getContainer()->get(IDriverProvider::class);
    }

    public static function getSettings(): ISettings
    {
        return self::getSettingsProvider()->getUserSettings();
    }

    protected static function getSettingsProvider(): ISettingsProvider
    {
        return self::getContainer()->get(ISettingsProvider::class);
    }
}
