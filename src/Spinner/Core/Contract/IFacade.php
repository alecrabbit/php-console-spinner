<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Facade;

interface IFacade
{
    public static function getDefaultsProvider(): IDefaultsProvider;

    public static function getLoop(): ILoop;

    public static function useService(string $id, object|callable|string $service): void;

    public static function getDriver(): IDriver;

    public static function createSpinner(?IWidgetSettings $settings): ISpinner;
}
