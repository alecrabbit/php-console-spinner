<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

final class Driver extends ASubject implements IDriver
{
    private ?ISpinner $spinner = null;
    private ISpinnerState $state;
    private IInterval $interval;

    public function __construct(
        protected readonly IDriverOutput $driverOutput,
        protected readonly ITimer $timer,
        protected readonly IInterval $initialInterval,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $initialInterval;
    }

    public function render(?float $dt = null): void
    {
        if ($this->spinner) {
            $dt ??= $this->timer->getDelta();
            $frame = $this->spinner->getFrame($dt);
            $this->state =
                new SpinnerState(
                    sequence: $frame->sequence(),
                    width: $frame->width(),
                    previousWidth: $this->state->getWidth()
                );

            $this->driverOutput->write($this->state);
        }
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->erase();
        $this->driverOutput->finalize($finalMessage);
    }

    private function erase(): void
    {
        if ($this->spinner) {
            $this->driverOutput->erase($this->state);
        }
    }

    public function initialize(): void
    {
        $this->driverOutput->initialize();
    }

    public function add(ISpinner $spinner): void
    {
        $this->erase();
        $spinner->attach($this);
        $this->spinner = $spinner;
        $this->state = new SpinnerState();
        $this->interval = $this->interval->smallest($spinner->getInterval());
        $this->notify();
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function remove(ISpinner $spinner): void
    {
        if ($this->spinner === $spinner) {
            $this->erase();
            $spinner->detach($this);
            $this->spinner = null;
            $this->interval = $this->recalculateInterval();
            $this->notify();
        }
    }

    private function recalculateInterval(): IInterval
    {
        return $this->initialInterval->smallest($this->spinner?->getInterval());
    }

    public function update(ISubject $subject): void
    {
        if ($this->spinner === $subject) {
            $this->interval = $this->recalculateInterval();
            $this->notify();
        }
    }
}
