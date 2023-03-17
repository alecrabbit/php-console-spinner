<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Factory\WidgetFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;

abstract class AConfigBuilder implements IConfigBuilder
{
    protected ?bool $autoStartEnabled = null;
    protected IDriverBuilder $driverBuilder;
    protected ?IWidgetComposite $rootWidget = null;
    protected ?IPattern $rootWidgetCharPattern = null;
    protected ?IPattern $rootWidgetStylePattern = null;
    protected ?bool $signalHandlersEnabled = null;
    protected IWidgetBuilder $widgetBuilder;
    protected IWidgetRevolverBuilder $widgetRevolverBuilder;
    protected ?\Traversable $widgets = null;

    public function __construct(
        protected IDefaults $defaults,
    ) {
        $this->widgetBuilder = WidgetFactory::getWidgetBuilder($this->defaults);
        $this->widgetRevolverBuilder = WidgetFactory::getWidgetRevolverBuilder($this->defaults);
        $this->driverBuilder = DriverFactory::getDriverBuilder($this->defaults);
    }

    public function withRootWidget(IWidgetComposite $widget): static
    {
        $clone = clone $this;
        $clone->rootWidget = $widget;
        return $clone;
    }

    public function withWidgets(\Traversable $widgets): static
    {
        $clone = clone $this;
        $clone->widgets = $widgets;
        return $clone;
    }

    public function withStylePattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->rootWidgetStylePattern = $pattern;
        return $clone;
    }

    public function withCharPattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->rootWidgetCharPattern = $pattern;
        return $clone;
    }

    public function build(): IConfig
    {
        $loopConfig =
            new LoopConfig(
                runMode: $this->defaults->getRunMode(),
                autoStart: $this->autoStartEnabled ?? $this->defaults->isAutoStartEnabled(),
                attachSignalHandlers: $this->signalHandlersEnabled ?? $this->defaults->areSignalHandlersEnabled(),
            );

        $spinnerConfig =
            new SpinnerConfig(
                rootWidget: $this->rootWidget ?? $this->createRootWidget(),
                createInitialized: $this->defaults->isCreateInitialized(),
                widgets: $this->widgets ?? new \ArrayObject([]),
            );

        return
            new Config(
                driver: $this->createDriver(),
                spinnerConfig: $spinnerConfig,
                loopConfig: $loopConfig,
            );
    }

    protected function createRootWidget(): IWidgetComposite
    {
        return
            $this->widgetBuilder
                ->withWidgetRevolver(
                    $this->widgetRevolverBuilder
                        ->withStyleRevolver(
                            RevolverFactory::createFrom(
                                $this->rootWidgetStylePattern
                                ?? $this->defaults->getRootWidgetSettings()->getStylePattern()
                                ?? $this->defaults->getStylePattern()
                            )
                        )
                        ->withCharRevolver(
                            RevolverFactory::createFrom(
                                $this->rootWidgetCharPattern
                                ?? $this->defaults->getRootWidgetSettings()->getCharPattern()
                                ?? $this->defaults->getCharPattern()
                            )
                        )
                        ->build()
                )
                ->withLeadingSpacer($this->defaults->getRootWidgetSettings()->getLeadingSpacer())
                ->withTrailingSpacer($this->defaults->getRootWidgetSettings()->getTrailingSpacer())
                ->build();
    }

    protected function createDriver(): IDriver
    {
        return
            $this->driverBuilder
                ->withOutput(new StreamOutput($this->defaults->getOutputStream()))
                ->withTimer(new Timer())
                ->build();
    }
}
