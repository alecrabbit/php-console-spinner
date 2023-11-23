<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final class Driver extends ADriver
{
    protected ?ISpinner $spinner = null;
    protected ISequenceState $state;

    public function __construct(
        ISequenceStateWriter $stateWriter,
        ISequenceStateBuilder $stateBuilder,
        IDeltaTimer $deltaTimer,
        IInterval $initialInterval,
        IDriverMessages $driverMessages,
        private readonly IIntervalComparator $intervalComparator,
        ?IObserver $observer = null
    ) {
        parent::__construct(
            driverMessages: $driverMessages,
            deltaTimer: $deltaTimer,
            initialInterval: $initialInterval,
            stateWriter: $stateWriter,
            stateBuilder: $stateBuilder,
            observer: $observer,
        );

        $this->state = $this->createState();
    }

    private function createState(
        string $sequence = '',
        int $width = 0,
        int $previousWidth = 0
    ): ISequenceState {
        return $this->stateBuilder
            ->withSequence($sequence)
            ->withWidth($width)
            ->withPreviousWidth($previousWidth)
            ->build()
        ;
    }

    public function add(ISpinner $spinner): void
    {
        $this->erase();

        if ($this->spinner) {
            $this->doRemove($this->spinner);
        }

        $frame = $spinner->getFrame();

        $this->state = $this->createState($frame->sequence(), $frame->width());

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
        return $this->intervalComparator->smallest($this->initialInterval, $this->spinner?->getInterval());
    }

    public function update(ISubject $subject): void
    {
        if ($this->spinner === $subject) {
            $this->interval = $this->recalculateInterval();
            $this->notify();
        }
    }

    public function remove(ISpinner $spinner): void
    {
        if ($this->spinner === $spinner) {
            $this->erase();
            $this->doRemove($spinner);
            $this->notify();
        }
    }

    public function has(ISpinner $spinner): bool
    {
        return $this->spinner === $spinner;
    }

    public function render(?float $dt = null): void
    {
        if ($this->spinner) {
            $frame =
                $this->spinner->getFrame(
                    $dt ?? $this->deltaTimer->getDelta()
                );

            $this->state = $this->createState(
                $frame->sequence(),
                $frame->width(),
                $this->state->getWidth(),
            );

            $this->stateWriter->write($this->state);
        }
    }
}
