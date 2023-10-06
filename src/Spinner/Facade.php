<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\A\AContainerEnclosure;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;

final class Facade extends AContainerEnclosure
{
    public static function getLoop(): ILoop
    {
        return self::getLoopFactory()->getLoop();
    }

    private static function getLoopFactory(): ILegacyLoopFactory
    {
        return self::getContainer()->get(ILegacyLoopFactory::class);
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $spinnerFactory = self::getSpinnerFactory();

        $spinner = $spinnerFactory->create($spinnerSettings);

        if ($spinnerSettings?->isAutoAttach() ?? true) {
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
            self::getSettingsProvider()->getSettings();
    }

    protected static function getSettingsProvider(): ISettingsProvider
    {
        return self::getContainer()->get(ISettingsProvider::class);
    }

}
