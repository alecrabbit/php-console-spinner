<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final class Driver extends ADriver
{
    protected ?ISpinner $spinner = null;
    protected ISequenceState $state;

    public function __construct(
        ISequenceStateWriter $output,
        ISequenceStateBuilder $stateBuilder,
        IDeltaTimer $deltaTimer,
        IInterval $initialInterval,
        IDriverConfig $driverConfig,
        ?IObserver $observer = null
    ) {
        parent::__construct(
            $driverConfig,
            $deltaTimer,
            $initialInterval,
            $output,
            $observer
        );

        $this->state = $this->initialState();
    }

    protected function initialState(): SequenceState
    {
        return
            new SequenceState();
    }

    /** @inheritDoc */
    public function add(ISpinner $spinner): void
    {
        $this->erase();

        if ($this->spinner) {
            $this->doRemove($this->spinner);
        }

        $frame = $spinner->getFrame();

        $this->state =
            new SequenceState(
                sequence: $frame->sequence(),
                width: $frame->width(),
                previousWidth: 0
            );

        $this->spinner = $spinner;
        $spinner->attach($this);
        $this->update($spinner);
    }

    protected function erase(): void
    {
        if ($this->spinner) {
            $this->stateWriter->erase($this->state);
        }
    }

    protected function doRemove(ISpinner $spinner): void
    {
        $spinner->detach($this);
        $this->spinner = null;
        $this->interval = $this->recalculateInterval();
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

    /** @inheritDoc */
    public function remove(ISpinner $spinner): void
    {
        if ($this->spinner === $spinner) {
            $this->erase();
            $this->doRemove($spinner);
            $this->notify();
        }
    }

    /** @inheritDoc */
    public function has(ISpinner $spinner): bool
    {
        return $this->spinner === $spinner;
    }

    /** @inheritDoc */
    public function render(?float $dt = null): void
    {
        if ($this->spinner) {
            $frame =
                $this->spinner->getFrame($dt ?? $this->deltaTimer->getDelta());

            $this->state =
                new SequenceState(
                    sequence: $frame->sequence(),
                    width: $frame->width(),
                    previousWidth: $this->state->getWidth()
                );

            $this->stateWriter->write($this->state);
        }
    }
}
