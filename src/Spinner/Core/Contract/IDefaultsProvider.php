<?php

declare(strict_types=1);

// 29.03.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;

interface IDefaultsProvider
{
    public function getAuxSettings(): IAuxSettings;

    public function getDriverSettings(): IDriverSettings;

    public function getLoopSettings(): ILoopSettings;

    public function getWidgetConfig(): IWidgetConfig;

    public function getRootWidgetConfig(): IWidgetConfig;

    public function getTerminalSettings(): ITerminalSettings;
}
