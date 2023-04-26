<?php

declare(strict_types=1);

// 29.03.23

namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;

final class DefaultsProvider implements IDefaultsProvider
{
    public function __construct(
        protected IAuxSettings $auxSettings,
        protected ITerminalSettings $terminalSettings,
        protected ILoopSettings $loopSettings,
        protected IDriverSettings $driverSettings,
        protected IWidgetConfig $widgetConfig,
        protected IWidgetConfig $rootWidgetConfig,
    ) {
    }

    public function getRootWidgetConfig(): IWidgetConfig
    {
        return $this->rootWidgetConfig;
    }

    public function getWidgetConfig(): IWidgetConfig
    {
        return $this->widgetConfig;
    }

    public function getDriverSettings(): IDriverSettings
    {
        return $this->driverSettings;
    }

    public function getLoopSettings(): ILoopSettings
    {
        return $this->loopSettings;
    }

    public function getTerminalSettings(): ITerminalSettings
    {
        return $this->terminalSettings;
    }

    public function getAuxSettings(): IAuxSettings
    {
        return $this->auxSettings;
    }
}
