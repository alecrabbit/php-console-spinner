<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\SpinnerState;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;

final class BenchmarkingDriver extends ADriver implements IBenchmarkingDriver
{
    protected ?ISpinner $spinner = null;
    protected ISpinnerState $state;
    private string $shortName;

    public function __construct(
        IDriverOutput $output,
        ITimer $timer,
        IInterval $initialInterval,
        ?IObserver $observer = null,
        private readonly IStopwatch $stopwatch = new Stopwatch(),
    ) {
        parent::__construct($output, $timer, $initialInterval, $observer);
        $this->shortName = (new \ReflectionClass($this))->getShortName();
    }

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
            $label = $this->createLabel(__FUNCTION__);

            $this->stopwatch->start($label, 'eraseState');
            $this->output->erase($this->state);
            $this->stopwatch->stop($label, 'eraseState');
        }
    }

    protected function createLabel(string $func): string
    {
        return $this->shortName . '::' . $func . '()';
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
            $label = $this->createLabel(__FUNCTION__);

            $this->stopwatch->start($label, 'createState');

            $dt ??= $this->timer->getDelta();
            $frame = $this->spinner->getFrame($dt);
            $this->state =
                new SpinnerState(
                    sequence: $frame->sequence(),
                    width: $frame->width(),
                    previousWidth: $this->state->getWidth()
                );

            $this->stopwatch->stop($label, 'createState');

            $this->stopwatch->start($label, 'writeState');
            $this->output->write($this->state);
            $this->stopwatch->stop($label, 'writeState');
        }
    }

    public function getStopwatch(): IStopwatch
    {
        return $this->stopwatch;
    }
}
