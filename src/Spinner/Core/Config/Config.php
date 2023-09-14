<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final readonly class Config implements IConfig
{
    public function __construct(
        protected IAuxConfig $auxConfig,
        protected ILoopConfig $loopConfig,
        protected IOutputConfig $outputConfig,
        protected IDriverConfig $driverConfig,
        protected IWidgetConfig $widgetConfig,
        protected IWidgetConfig $rootWidgetConfig,
    ) {
    }

    public function getAuxConfig(): IAuxConfig
    {
        return $this->auxConfig;
    }

    public function getLoopConfig(): ILoopConfig
    {
        return $this->loopConfig;
    }

    public function getOutputConfig(): IOutputConfig
    {
        return $this->outputConfig;
    }

    public function getDriverConfig(): IDriverConfig
    {
        return $this->driverConfig;
    }

    public function getWidgetConfig(): IWidgetConfig
    {
        return $this->widgetConfig;
    }

    public function getRootWidgetConfig(): IWidgetConfig
    {
        return $this->rootWidgetConfig;
    }

    public function set(IConfigElement ...$settingsElements): void
    {
        // TODO: Implement set() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function get(string $id): ?IConfigElement
    {
        // TODO: Implement get() method.
        throw new \RuntimeException('Not implemented.');
    }
}
