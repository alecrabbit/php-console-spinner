<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;

final class DefaultsProvider implements IDefaultsProvider
{
    public function __construct(
        protected IAuxSettings $auxSettings,
        protected ILoopSettings $loopSettings,
        protected ILegacySpinnerSettings $spinnerSettings,
        protected IDriverSettings $driverSettings,
        protected IWidgetSettings $widgetSettings,
        protected IWidgetSettings $rootWidgetSettings,
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

    public function getSpinnerSettings(): ILegacySpinnerSettings
    {
        return $this->spinnerSettings;
    }

    public function getLoopSettings(): ILoopSettings
    {
        return $this->loopSettings;
    }

    public function getAuxSettings(): IAuxSettings
    {
        return $this->auxSettings;
    }
}
