<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\A;

use AlecRabbit\Spinner\Config\Config;
use AlecRabbit\Spinner\Config\Contract\IConfig;
use AlecRabbit\Spinner\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ITimer;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Output\Contract\IDriver;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Pattern\Style\RevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Factory\WidgetFactory;

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
    protected ?IRevolver $spinnerStyleRevolver = null;
    protected ?IRevolver $spinnerCharRevolver = null;
    /** @var array<IWidgetComposite>|null */
    protected ?array $widgets = null;
    protected ?IWidgetBuilder $widgetBuilder = null;
    protected ?IWidgetComposite $mainWidget = null;

    public function __construct(
        protected IDefaults $defaults,
    ) {
        $this->initializeBuildersAndFactories($this->defaults);
    }

    protected function initializeBuildersAndFactories(IDefaults $defaults): void
    {
        $this->widgetBuilder = WidgetFactory::getWidgetBuilder();
    }

    public function withMainWidget(IWidgetComposite $widget): self
    {
        $clone = clone $this;
        $clone->mainWidget = $widget;
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

    public function withWidgets(array $widgets): self
    {
        $clone = clone $this;
        $clone->widgets = $widgets;
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
                driver: $this->driver,
                timer: $this->timer,
                mainWidget: $this->mainWidget,
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
        $this->hideCursor ??= $this->defaults->isHideCursor();
        $this->createInitialized ??= $this->defaults->isCreateInitialized();
        $this->inSynchronousMode ??= $this->defaults->isModeSynchronous();
        $this->autoStartEnabled ??= $this->defaults->isAutoStartEnabled();
        $this->signalHandlersEnabled ??= $this->defaults->areSignalHandlersEnabled();
        $this->interruptMessage ??= $this->defaults->getInterruptMessage();
        $this->finalMessage ??= $this->defaults->getFinalMessage();

        $this->output ??= $this->createOutput();
        $this->driver ??= $this->createDriver();

        $this->spinnerStyleRevolver ??=
            (new RevolverBuilder())
                ->withPattern($this->defaults->getSpinnerStylePattern())
                ->build();

        $this->spinnerCharRevolver ??=
            (new RevolverBuilder())
                ->withPattern($this->defaults->getSpinnerCharPattern())
                ->build();

        $this->widgetRevolver ??=
            new WidgetRevolver(
                style: $this->spinnerStyleRevolver,
                character: $this->spinnerCharRevolver,
            );

        $this->leadingSpacer ??= $this->defaults->getDefaultLeadingSpacer();
        $this->trailingSpacer ??= $this->defaults->getDefaultTrailingSpacer();

        $this->mainWidget ??=
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

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function createSpinnerStyleRevolver(IStylePattern $spinnerStylePattern): IRevolver
    {
        return
            (new RevolverBuilder())
                ->withPattern($spinnerStylePattern)
                ->build();
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function createSpinnerCharRevolver(IPattern $spinnerCharPattern): IRevolver
    {
        return
            (new RevolverBuilder())
                ->withPattern($spinnerCharPattern)
                ->build();
    }


    protected function createWidgetRevolver(IRevolver $spinnerStyleRevolver, IRevolver $spinnerCharRevolver): IRevolver
    {
        return
            new WidgetRevolver(
                style: $spinnerStyleRevolver,
                character: $spinnerCharRevolver,
            );
    }
}
