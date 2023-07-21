<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class Settings implements ISettings
{
    public function __construct(
        protected RunMethodOption $runMethodOption = RunMethodOption::AUTO,
        protected readonly IAuxSettings $auxSettings = new AuxSettings(),
        protected readonly ILoopSettings $loopSettings = new LoopSettings(),
        protected readonly IOutputSettings $outputSettings = new OutputSettings(),
        protected readonly IDriverSettings $driverSettings = new DriverSettings(),
        protected readonly IWidgetSettings $widgetSettings = new WidgetSettings(),
        protected readonly IWidgetSettings $rootWidgetSettings = new WidgetSettings(),
    ) {
    }

    public function getRunMethodOption(): RunMethodOption
    {
        return $this->runMethodOption;
    }

    public function setRunMethodOption(RunMethodOption $runMethodOption): void
    {
        $this->runMethodOption = $runMethodOption;
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
