<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\Timer;

abstract class ADriverBuilder implements IDriverBuilder
{
    protected ?IDriverSettings $driverSettings = null;
    protected ?IOutput $output = null;
    protected ?ITerminalSettings $terminalSettings = null;
    protected ?ITimer $timer = null;

    public function __construct(
        protected IDefaults $defaults,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function build(): IDriver
    {
        $this->output ??= new StreamOutput($this->defaults->getOutputStream());
        $this->timer ??= new Timer();
        $this->terminalSettings ??= $this->defaults->getTerminalSettings();
        $this->driverSettings ??= $this->defaults->getDriverSettings();

        return
            new Driver(
                output: $this->output,
                timer: $this->timer,
                hideCursor: $this->terminalSettings->isHideCursor(),
                interruptMessage: $this->driverSettings->getInterruptMessage(),
                finalMessage: $this->driverSettings->getFinalMessage(),
            );
    }

    public function withOutput(IOutput $output): static
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withTimer(ITimer $timer): static
    {
        $clone = clone $this;
        $clone->timer = $timer;
        return $clone;
    }

    public function withTerminalSettings(ITerminalSettings $terminalSettings): static
    {
        $clone = clone $this;
        $clone->terminalSettings = $terminalSettings;
        return $clone;
    }

    public function withDriverSettings(IDriverSettings $driverSettings): static
    {
        $clone = clone $this;
        $clone->driverSettings = $driverSettings;
        return $clone;
    }


}