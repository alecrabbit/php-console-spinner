<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\SpinnerState;

final class BenchmarkingDriver extends ADriver
{
    protected ?ISpinner $spinner = null;
    protected ISpinnerState $state;

    /** @inheritDoc */
    public function add(ISpinner $spinner): void
    {
        $this->erase();

        $this->state = new SpinnerState();

        $this->spinner = $spinner;
        $spinner->attach($this);
        $this->update($spinner);
    }

    protected function erase(): void
    {
        if ($this->spinner) {
            $this->output->erase($this->state);
        }
    }

    public function update(ISubject $subject): void
    {
        if ($this->spinner === $subject) {
            $this->interval = $this->recalculateInterval();
            $this->notify();
        }
    }

    protected function recalculateInterval(): IInterval
    {
        return $this->initialInterval->smallest($this->spinner?->getInterval());
    }

    /** @inheritDoc */
    public function has(ISpinner $spinner): bool
    {
        return $this->spinner === $spinner;
    }

    /** @inheritDoc */
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

    /** @inheritDoc */
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
