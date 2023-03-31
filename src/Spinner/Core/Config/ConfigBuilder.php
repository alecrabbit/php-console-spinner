<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\A\ABuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final class ConfigBuilder extends ABuilder implements IConfigBuilder
{
    protected ?IDriverConfig $driverConfig = null;
    protected ?ILoopConfig $loopConfig = null;
    protected ?ISpinnerConfig $spinnerConfig = null;
    protected ?IWidgetConfig $rootWidgetConfig = null;

    public function withDriverConfig(IDriverConfig $driverConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->driverConfig = $driverConfig;
        return $clone;
    }

    public function withLoopConfig(ILoopConfig $loopConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->loopConfig = $loopConfig;
        return $clone;
    }

    public function withSpinnerConfig(ISpinnerConfig $spinnerConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->spinnerConfig = $spinnerConfig;
        return $clone;
    }

    public function withRootWidgetConfig(IWidgetConfig $widgetConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->rootWidgetConfig = $widgetConfig;
        return $clone;
    }

    public function build(): IConfig
    {
        return
            new Config(
                $this->driverConfig ?? $this->defaultDriverConfig(),
                $this->loopConfig ?? $this->defaultLoopConfig(),
                $this->spinnerConfig ?? $this->defaultSpinnerConfig(),
                $this->rootWidgetConfig ?? $this->defaultRootWidgetConfig(),
            );
    }

    protected function defaultDriverConfig(): IDriverConfig
    {
        $defaults = $this->getDefaultsProvider();
        return
            new DriverConfig(
                $defaults->getDriverSettings()->getInterruptMessage(),
                $defaults->getDriverSettings()->getFinalMessage(),
            );
    }

    protected function defaultLoopConfig(): ILoopConfig
    {
        $defaults = $this->getDefaultsProvider();
        return
            new LoopConfig(
                $defaults->getLoopSettings()->getRunModeOption(),
                $defaults->getLoopSettings()->getAutoStartOption(),
                $defaults->getLoopSettings()->getSignalHandlersOption(),
            );
    }

    protected function defaultSpinnerConfig(): ISpinnerConfig
    {
        $defaults = $this->getDefaultsProvider();
        return
            new SpinnerConfig(
                $defaults->getSpinnerSettings()->getInitializationOption(),
            );
    }

    protected function defaultRootWidgetConfig(): IWidgetConfig
    {
        $defaults = $this->getDefaultsProvider();
        $settings = $defaults->getRootWidgetSettings();
        return
            new WidgetConfig(
                $settings->getLeadingSpacer(),
                $settings->getTrailingSpacer(),
                $settings->getStylePattern(),
                $settings->getCharPattern(),
            );
    }
}
