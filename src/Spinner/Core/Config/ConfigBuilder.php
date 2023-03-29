<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\ABuilder;
use AlecRabbit\Spinner\Core\Config\A\AConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use Traversable;

final class ConfigBuilder extends ABuilder implements IConfigBuilder
{
    protected ?IWidgetConfig $rootWidgetConfig = null;
    protected ?ISpinnerConfig $spinnerConfig = null;
    protected ?ILoopConfig $loopConfig = null;
    protected ?IDriverConfig $driverConfig = null;

    public function withDriverConfig(IDriverConfig $driverConfig): static
    {
        $clone = clone $this;
        $clone->driverConfig = $driverConfig;
        return $clone;
    }

    public function withLoopConfig(ILoopConfig $loopConfig): static
    {
        $clone = clone $this;
        $clone->loopConfig = $loopConfig;
        return $clone;
    }

    public function withSpinnerConfig(ISpinnerConfig $spinnerConfig): static
    {
        $clone = clone $this;
        $clone->spinnerConfig = $spinnerConfig;
        return $clone;
    }

    public function withRootWidgetConfig(IWidgetConfig $widgetConfig): static
    {
        $clone = clone $this;
        $clone->rootWidgetConfig = $widgetConfig;
        return $clone;
    }

    public function build(): IConfig
    {
        return new Config(
            $this->driverConfig ?? $this->defaultDriverConfig(),
            $this->loopConfig ?? $this->defaultLoopConfig(),
            $this->spinnerConfig ?? $this->defaultSpinnerConfig(),
            $this->rootWidgetConfig ?? $this->defaultRootWidgetConfig(),
        );
    }

    protected function defaultDriverConfig(): IDriverConfig
    {
        return new DriverConfig();
    }

    protected function defaultLoopConfig(): ILoopConfig
    {
        return new LoopConfig();
    }

    protected function defaultSpinnerConfig(): ISpinnerConfig
    {
        return new SpinnerConfig();
    }

    protected function defaultRootWidgetConfig(): IWidgetConfig
    {
        return new WidgetConfig();
    }
}
