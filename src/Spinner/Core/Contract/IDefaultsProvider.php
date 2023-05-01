<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ITerminalSettings;

interface IDefaultsProvider
{
    public function getAuxSettings(): IAuxSettings;

    public function getDriverSettings(): IDriverSettings;

    public function getLoopSettings(): ILoopSettings;

    public function getWidgetConfig(): IWidgetConfig;

    public function getRootWidgetConfig(): IWidgetConfig;

    public function getTerminalSettings(): ITerminalSettings;
}
