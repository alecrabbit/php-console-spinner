<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Container\Mixin\AutoInstantiableTrait;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final class ConfigBuilder implements IConfigBuilder
{
    use AutoInstantiableTrait;

    protected ?IDriverConfig $driverConfig = null;
    protected ?ILoopConfig $loopConfig = null;
    protected ?ISpinnerConfig $spinnerConfig = null;
    protected ?IWidgetConfig $rootWidgetConfig = null;

    public function __construct(
        protected IDefaultsProvider $defaultsProvider
    ) {
    }


    public
    function withDriverConfig(
        IDriverConfig $driverConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->driverConfig = $driverConfig;
        return $clone;
    }

    public
    function withLoopConfig(
        ILoopConfig $loopConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->loopConfig = $loopConfig;
        return $clone;
    }

    public
    function withSpinnerConfig(
        ISpinnerConfig $spinnerConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->spinnerConfig = $spinnerConfig;
        return $clone;
    }

    public
    function withRootWidgetConfig(
        IWidgetConfig $widgetConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->rootWidgetConfig = $widgetConfig;
        return $clone;
    }

    public
    function build(): IConfig
    {
        return
            new Config(
                $this->driverConfig ?? $this->defaultDriverConfig(),
                $this->loopConfig ?? $this->defaultLoopConfig(),
                $this->spinnerConfig ?? $this->defaultSpinnerConfig(),
                $this->rootWidgetConfig ?? $this->defaultRootWidgetConfig(),
            );
    }

    protected
    function defaultDriverConfig(): IDriverConfig
    {
        $driverSettings = $this->defaultsProvider->getDriverSettings();
        return
            new DriverConfig(
                $driverSettings->getInterruptMessage(),
                $driverSettings->getFinalMessage(),
            );
    }

    protected
    function defaultLoopConfig(): ILoopConfig
    {
        $loopSettings = $this->defaultsProvider->getLoopSettings();
        return
            new LoopConfig(
                $loopSettings->getRunModeOption(),
                $loopSettings->getAutoStartOption(),
                $loopSettings->getSignalHandlersOption(),
            );
    }

    protected
    function defaultSpinnerConfig(): ISpinnerConfig
    {
        $spinnerSettings = $this->defaultsProvider->getSpinnerSettings();
        return
            new SpinnerConfig(
                $spinnerSettings->getInitializationOption(),
            );
    }

    protected
    function defaultRootWidgetConfig(): IWidgetConfig
    {
        $rootWidgetSettings = $this->defaultsProvider->getRootWidgetSettings();
        return
            new WidgetConfig(
                $rootWidgetSettings->getLeadingSpacer(),
                $rootWidgetSettings->getTrailingSpacer(),
                $rootWidgetSettings->getStylePattern(),
                $rootWidgetSettings->getCharPattern(),
            );
    }
}
