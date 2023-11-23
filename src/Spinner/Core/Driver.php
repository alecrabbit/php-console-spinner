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
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final class Driver extends ADriver
{
    private ?ISpinner $spinner = null;

    public function __construct(
        IRenderer $renderer,
        ISequenceStateBuilder $stateBuilder,
        IDeltaTimer $deltaTimer,
        IInterval $initialInterval,
        IDriverMessages $driverMessages,
        private readonly IIntervalComparator $intervalComparator,
        ?IObserver $observer = null
    ) {
        parent::__construct(
            initialInterval: $initialInterval,
            driverMessages: $driverMessages,
            renderer: $renderer,
            deltaTimer: $deltaTimer,
            stateBuilder: $stateBuilder,
            observer: $observer,
        );

    }

    public function add(ISpinner $spinner): void
    {
        $this->erase();

        if ($this->spinner) {
            $this->doRemove($this->spinner);
        }

        $this->spinner = $spinner;

        $this->render();

        $spinner->attach($this);
        $this->update($spinner);
    }

    protected function erase(): void
    {
        if ($this->spinner) {
            $this->renderer->erase($this->spinner);
        }
    }

    protected function doRemove(ISpinner $spinner): void
    {
        $spinner->detach($this);
        $this->spinner = null;
        $this->interval = $this->smallestInterval();
    }

    protected function smallestInterval(): IInterval
    {
        return $this->intervalComparator->smallest(
            $this->initialInterval,
            $this->spinner?->getInterval(),
        );
    }

    public function update(ISubject $subject): void
    {
        if ($this->spinner === $subject) {
            $this->interval = $this->smallestInterval();
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
            $this->renderer->render($this->spinner, $dt);
        }
    }
}
