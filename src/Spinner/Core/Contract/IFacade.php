<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

interface IFacade
{
    public static function getSettingsProvider(): ISettingsProvider;

    public static function getLoop(): ILoop;

    public static function getDriver(): IDriver;

    public static function createSpinner(
        ISpinnerConfig|IWidgetConfig|null $config = null,
        bool $attach = true
    ): ISpinner;
}
