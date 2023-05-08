<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use Closure;

final class Driver extends ADriver
{
    protected ?ISpinner $spinner = null;
    protected ISpinnerState $state;




    protected function erase(): void
    {
        if ($this->spinner) {
            $this->output->erase($this->state);
        }
    }

    /** @inheritdoc */
    public function initialize(): void
    {
        $this->output->initialize();
    }

    /** @inheritdoc */
    public function add(ISpinner $spinner): void
    {
        $this->erase();
        $spinner->attach($this);
        $this->spinner = $spinner;
        $this->state = new SpinnerState();
        $this->interval = $this->interval->smallest($spinner->getInterval());
        $this->notify();
    }


    /** @inheritdoc */
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

    protected function recalculateInterval(): IInterval
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


    /** @inheritdoc */
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

            $this->output->write($this->state);
        }
    }
}
