<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;

final class ConfigBuilder implements IConfigBuilder
{
    protected ?IDriverConfig $driverConfig = null;
    protected ?ILoopConfig $loopConfig = null;
    protected ?ISpinnerConfig $spinnerConfig = null;
    protected ?IWidgetConfig $rootWidgetConfig = null;
    protected ?IAuxConfig $auxConfig = null;

    public function __construct(
        protected IDefaultsProvider $defaultsProvider
    ) {
    }

    public function getDefaultsProvider(): IDefaultsProvider
    {
        return $this->defaultsProvider;
    }

    public function withDriverConfig(
        IDriverConfig $driverConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->driverConfig = $driverConfig;
        return $clone;
    }

    public function withLoopConfig(
        ILoopConfig $loopConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->loopConfig = $loopConfig;
        return $clone;
    }

    public function withSpinnerConfig(
        ISpinnerConfig $spinnerConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->spinnerConfig = $spinnerConfig;
        return $clone;
    }

    public function withRootWidgetConfig(
        IWidgetConfig $widgetConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->rootWidgetConfig = $widgetConfig;
        return $clone;
    }

    public function withAuxConfig(
        IAuxConfig $auxConfig
    ): IConfigBuilder {
        $clone = clone $this;
        $clone->auxConfig = $auxConfig;
        return $clone;
    }

    public function build(): IConfig
    {
        return
            new Config(
                $this->auxConfig ?? $this->defaultAuxConfig(),
                $this->driverConfig ?? $this->defaultDriverConfig(),
                $this->loopConfig ?? $this->defaultLoopConfig(),
                $this->spinnerConfig ?? $this->defaultSpinnerConfig(),
                $this->rootWidgetConfig ?? $this->defaultRootWidgetConfig(),
            );
    }

    private function defaultAuxConfig(): IAuxConfig
    {
        $auxSettings = $this->defaultsProvider->getAuxSettings();
        return
            new AuxConfig(
                $auxSettings->getInterval(),
                $auxSettings->getNormalizerMode(),
                $auxSettings->getCursorOption(),
                $auxSettings->getOptionStyleMode(),
                $auxSettings->getOutputStream(),
            );
    }

    protected function defaultDriverConfig(): IDriverConfig
    {
        $driverSettings = $this->defaultsProvider->getDriverSettings();
        return
            new DriverConfig(
                $driverSettings->getInterruptMessage(),
                $driverSettings->getFinalMessage(),
            );
    }

    protected function defaultLoopConfig(): ILoopConfig
    {
        $loopSettings = $this->defaultsProvider->getLoopSettings();
        return
            new LoopConfig(
                $loopSettings->getRunModeOption(),
                $loopSettings->isAutoStartEnabled(),
                $loopSettings->isAttachHandlersEnabled(),
            );
    }

    protected function defaultSpinnerConfig(): ISpinnerConfig
    {
        $spinnerSettings = $this->defaultsProvider->getSpinnerSettings();
        return
            new SpinnerConfig(
                $spinnerSettings->getInitializationOption(),
                $spinnerSettings->getAttachOption(),
            );
    }

    protected function defaultRootWidgetConfig(): IWidgetConfig
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
