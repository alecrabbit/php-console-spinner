<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;

interface IDefaultsProvider
{
    public function getRootWidgetSettings(): IWidgetSettings;

    public function getWidgetSettings(): IWidgetSettings;

    public function getDriverSettings(): IDriverSettings;

    public function getSpinnerSettings(): ISpinnerSettings;

    public function getLoopSettings(): ILoopSettings;

    public function getAuxSettings(): IAuxSettings;
}
