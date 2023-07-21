<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final readonly class Settings implements ISettings
{
    public function __construct(
        protected IAuxSettings $auxSettings = new AuxSettings(),
        protected ILoopSettings $loopSettings = new LoopSettings(),
        protected IOutputSettings $outputSettings = new OutputSettings(),
        protected IDriverSettings $driverSettings = new DriverSettings(),
        protected IWidgetSettings $widgetSettings = new WidgetSettings(),
        protected IWidgetSettings $rootWidgetSettings = new WidgetSettings(),
    ) {
    }

    public function getAuxSettings(): IAuxSettings
    {
        return $this->auxSettings;
    }

    public function getWidgetSettings(): IWidgetSettings
    {
        return $this->widgetSettings;
    }

    public function getRootWidgetSettings(): IWidgetSettings
    {
        return $this->rootWidgetSettings;
    }

    public function getDriverSettings(): IDriverSettings
    {
        return $this->driverSettings;
    }

    public function getLoopSettings(): ILoopSettings
    {
        return $this->loopSettings;
    }

    public function getOutputSettings(): IOutputSettings
    {
        return $this->outputSettings;
    }
}
