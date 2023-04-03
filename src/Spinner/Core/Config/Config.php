<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final readonly class Config implements IConfig
{
    public function __construct(
        protected IDriverConfig $driverConfig,
        protected ILoopConfig $loopConfig,
        protected ISpinnerConfig $spinnerConfig,
        protected IWidgetConfig $rootWidgetConfig,
        protected IAuxConfig $auxConfig,
    ) {
    }

    public function getDriverConfig(): IDriverConfig
    {
        return $this->driverConfig;
    }

    public function getLoopConfig(): ILoopConfig
    {
        return $this->loopConfig;
    }

    public function getSpinnerConfig(): ISpinnerConfig
    {
        return $this->spinnerConfig;
    }

    public function getRootWidgetConfig(): IWidgetConfig
    {
        return $this->rootWidgetConfig;
    }

    public function getAuxConfig(): IAuxConfig
    {
        return $this->auxConfig;
    }
}
