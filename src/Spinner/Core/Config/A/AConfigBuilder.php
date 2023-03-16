<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Factory\WidgetFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

abstract class AConfigBuilder implements IConfigBuilder
{
    protected ?IRevolver $widgetRevolver = null;
    protected ?bool $autoStartEnabled = null;
    protected ?bool $signalHandlersEnabled = null;
    protected ?IRevolver $rootWidgetStyleRevolver = null;
    protected ?IRevolver $rootWidgetCharRevolver = null;
    protected iterable $widgets = [];
    protected IWidgetBuilder $widgetBuilder;
    protected IWidgetRevolverBuilder $widgetRevolverBuilder;
    protected ?IWidgetComposite $rootWidget = null;
    protected ?IPattern $rootWidgetStylePattern = null;
    protected ?IPattern $rootWidgetCharPattern = null;

    public function __construct(
        protected IDefaults $defaults,
    ) {
        $this->widgetBuilder = WidgetFactory::getWidgetBuilder($this->defaults);
        $this->widgetRevolverBuilder = WidgetFactory::getWidgetRevolverBuilder($this->defaults);
    }

    public function withRootWidget(IWidgetComposite $widget): static
    {
        $clone = clone $this;
        $clone->rootWidget = $widget;
        return $clone;
    }

    public function withWidgets(iterable $widgets): static
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

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig
    {
        $this->processDefaults();

        return
            new Config(
                driver: $this->createDriver($this->createOutput()),
                timer: new Timer(),
                rootWidget: $this->rootWidget,
                createInitialized: $this->defaults->isCreateInitialized(),
                runMode: $this->defaults->getRunMode(),
                autoStart: $this->autoStartEnabled,
                attachSignalHandlers: $this->signalHandlersEnabled,
                widgets: $this->widgets,
            );
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function processDefaults(): void
    {
        $this->timer ??= new Timer();
        $this->autoStartEnabled ??= $this->defaults->isAutoStartEnabled();
        $this->signalHandlersEnabled ??= $this->defaults->areSignalHandlersEnabled();

        $this->rootWidgetStylePattern ??=
            $this->defaults->getRootWidgetSettings()->getStylePattern() ?? $this->defaults->getStylePattern();

        $this->rootWidgetCharPattern ??=
            $this->defaults->getRootWidgetSettings()->getCharPattern() ?? $this->defaults->getCharPattern();

        $this->rootWidgetStyleRevolver ??=
            RevolverFactory::createFrom($this->rootWidgetStylePattern);

        $this->rootWidgetCharRevolver ??=
            RevolverFactory::createFrom($this->rootWidgetCharPattern);

        $this->widgetRevolver ??=
            $this->widgetRevolverBuilder
                ->withStyleRevolver($this->rootWidgetStyleRevolver)
                ->withCharRevolver($this->rootWidgetCharRevolver)
                ->build();

        $this->rootWidget ??=
            $this->widgetBuilder
                ->withWidgetRevolver($this->widgetRevolver)
                ->withLeadingSpacer($this->defaults->getWidgetSettings()->getLeadingSpacer())
                ->withTrailingSpacer($this->defaults->getWidgetSettings()->getTrailingSpacer())
                ->build();
    }

    protected function createDriver(IOutput $output): IDriver
    {
        return
            new Driver(
                output: $output,
                hideCursor: $this->defaults->getTerminalSettings()->isHideCursor(),
                interruptMessage: $this->defaults->getDriverSettings()->getInterruptMessage(),
                finalMessage: $this->defaults->getDriverSettings()->getFinalMessage(),
            );
    }

    protected function createOutput(): IOutput
    {
        return
            new StreamOutput($this->defaults->getOutputStream());
    }
}
