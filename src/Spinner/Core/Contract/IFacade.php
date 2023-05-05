<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

interface IFacade
{
    public static function getSettingsProvider(): ISettingsProvider;

    public static function getLoop(): ILoop;

    public static function bind(string $typeId, object|callable|string $service): void;

    public static function getDriver(): IDriver;

    public static function createSpinner(?ISpinnerConfig $config = null): ISpinner;
}
