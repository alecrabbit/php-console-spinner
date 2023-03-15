<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Factory\WidgetFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\RevolverBuilder;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

abstract class AConfigBuilder implements IConfigBuilder
{
    protected ?IDriver $driver = null;
    protected ?ITimer $timer = null;
    protected ?IRevolver $widgetRevolver = null;
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?bool $hideCursor = null;
    protected ?bool $createInitialized = null;
    protected ?bool $inSynchronousMode = null;
    protected ?bool $autoStartEnabled = null;
    protected ?bool $signalHandlersEnabled = null;
    protected ?string $interruptMessage = null;
    protected ?string $finalMessage = null;
    protected ?IOutput $output = null;
    protected ?IRevolver $rootWidgetStyleRevolver = null;
    protected ?IRevolver $rootWidgetCharRevolver = null;
    protected ?iterable $widgets = null;
    protected ?IWidgetBuilder $widgetBuilder = null;
    protected ?IWidgetRevolverBuilder $widgetRevolverBuilder = null;
    protected ?IWidgetComposite $rootWidget = null;
    protected ?IPattern $rootWidgetStylePattern = null;
    protected ?IPattern $rootWidgetCharPattern = null;

    public function __construct(
        protected IDefaults $defaults,
    ) {
        $this->initializeBuildersAndFactories();
    }

    protected function initializeBuildersAndFactories(): void
    {
        $this->widgetBuilder = WidgetFactory::getWidgetBuilder();
        $this->widgetRevolverBuilder = WidgetFactory::getWidgetRevolverBuilder();
    }

    public function withRootWidget(IWidgetComposite $widget): static
    {
        $clone = clone $this;
        $clone->rootWidget = $widget;
        return $clone;
    }

    public function withInterruptMessage(string $interruptMessage): self
    {
        $clone = clone $this;
        $clone->interruptMessage = $interruptMessage;
        return $clone;
    }

    public function withFinalMessage(string $finalMessage): self
    {
        $clone = clone $this;
        $clone->finalMessage = $finalMessage;
        return $clone;
    }

    public function withCursor(): self
    {
        $clone = clone $this;
        $clone->hideCursor = false;
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

//    /**
//     * @throws LogicException
//     * @throws InvalidArgumentException
//     */
//    protected function createSpinnerCharRevolver(IPattern $spinnerCharPattern): IRevolver
//    {
//        return
//            (new RevolverBuilder())
//                ->withPattern($spinnerCharPattern)
//                ->build();
//    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig
    {
        $this->processDefaults();

        return
            new Config(
                driver: $this->driver,
                timer: $this->timer,
                rootWidget: $this->rootWidget,
                createInitialized: $this->createInitialized,
                synchronous: $this->inSynchronousMode,
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
        $this->hideCursor ??= $this->defaults->getTerminalSettings()->isHideCursor();
        $this->createInitialized ??= $this->defaults->isCreateInitialized();
        $this->inSynchronousMode ??= $this->defaults->isModeSynchronous();
        $this->autoStartEnabled ??= $this->defaults->isAutoStartEnabled();
        $this->signalHandlersEnabled ??= $this->defaults->areSignalHandlersEnabled();
        $this->interruptMessage ??= $this->defaults->getDriverSettings()->getInterruptMessage();
        $this->finalMessage ??= $this->defaults->getDriverSettings()->getFinalMessage();

        $this->output ??= $this->createOutput();
        $this->driver ??= $this->createDriver();

        $this->rootWidgetStylePattern ??=
            $this->defaults->getSpinnerStylePattern();

        $this->rootWidgetCharPattern ??=
            $this->defaults->getSpinnerCharPattern();

        $this->rootWidgetStyleRevolver ??=
            (new RevolverBuilder())
                ->withPattern($this->rootWidgetStylePattern)
                ->build();

        $this->rootWidgetCharRevolver ??=
            (new RevolverBuilder())
                ->withPattern($this->rootWidgetCharPattern)
                ->build();

        $this->widgetRevolver ??=
            new WidgetRevolver(
                style: $this->rootWidgetStyleRevolver,
                character: $this->rootWidgetCharRevolver,
            );

        $this->leadingSpacer ??= $this->defaults->getDefaultLeadingSpacer();
        $this->trailingSpacer ??= $this->defaults->getDefaultTrailingSpacer();

        $this->rootWidget ??=
            $this->widgetBuilder
                ->withWidgetRevolver($this->widgetRevolver)
                ->withLeadingSpacer($this->leadingSpacer)
                ->withTrailingSpacer($this->trailingSpacer)
                ->build();

        $this->widgets ??= [];
    }

    protected function createOutput(): IOutput
    {
        return
            new StreamOutput($this->defaults->getOutputStream());
    }

    protected function createDriver(): IDriver
    {
        return
            new Driver(
                output: $this->output,
                hideCursor: $this->hideCursor,
                interruptMessage: $this->interruptMessage,
                finalMessage: $this->finalMessage,
            );
    }

//    protected function createWidgetRevolver(IRevolver $spinnerStyleRevolver, IRevolver $spinnerCharRevolver): IRevolver
//    {
//        return
//            new WidgetRevolver(
//                style: $spinnerStyleRevolver,
//                character: $spinnerCharRevolver,
//            );
//    }
}
