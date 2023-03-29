<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;

final class DefaultsProvider implements IDefaultsProvider
{
    public function __construct(
        protected IWidgetSettings $rootWidgetSettings = new WidgetSettings(),
        protected IWidgetSettings $widgetSettings = new WidgetSettings(),
        protected IDriverSettings $driverSettings = new DriverSettings(),
        protected ISpinnerSettings $spinnerSettings = new SpinnerSettings(),
        protected ILoopSettings $loopSettings = new LoopSettings(),
    ) {
    }

    public function getRootWidgetSettings(): IWidgetSettings
    {
        return $this->rootWidgetSettings;
    }

    public function getWidgetSettings(): IWidgetSettings
    {
        return $this->widgetSettings;
    }

    public function getDriverSettings(): IDriverSettings
    {
        return $this->driverSettings;
    }

    public function getSpinnerSettings(): ISpinnerSettings
    {
        return $this->spinnerSettings;
    }

    public function getLoopSettings(): ILoopSettings
    {
        return $this->loopSettings;
    }
}