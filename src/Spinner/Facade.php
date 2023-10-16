<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Exception\DomainException;

final class Facade extends AFacade
{
    private static bool $configurationCreated = false;

    public static function getLoop(): ILoop
    {
        self::initialize();

        return
            self::getLoopProvider()
                ->getLoop()
        ;
    }

    private static function initialize(): void
    {
        self::$configurationCreated = true;
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        self::initialize();

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
        self::initialize();

        return
            self::getDriverProvider()
                ->getDriver()
        ;
    }

    /** @inheritDoc */
    public static function getSettings(): ISettings
    {
        self::assertNotInitialized();

        return
            self::getSettingsProvider()
                ->getUserSettings()
        ;
    }

    /**
     * @throws DomainException
     */
    protected static function assertNotInitialized(): void
    {
        if (self::$configurationCreated) {
            throw new DomainException(
                'Settings can not be changed. Configuration is already created.'
            );
        }
    }

}
