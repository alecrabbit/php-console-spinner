<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

abstract readonly class AConfig
{
    public function __construct(
        protected IDriver $driver,
        protected ISpinnerConfig $spinnerConfig,
        protected ILoopConfig $loopConfig,
    ) {
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }

    public function getLoopConfig(): ILoopConfig
    {
        return $this->loopConfig;
    }

    public function getSpinnerConfig(): ISpinnerConfig
    {
        return $this->spinnerConfig;
    }

    public function getDriverConfig(): IDriverConfig
    {
        // TODO: Implement getDriverConfig() method.
    }

    public function getRootWidgetConfig(): IWidgetConfig
    {
        // TODO: Implement getRootWidgetConfig() method.
    }
}
