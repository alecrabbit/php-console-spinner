<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ITerminalSettings;

final class SettingsProvider implements ISettingsProvider
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
