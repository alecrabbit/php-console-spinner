<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Closure;
use WeakMap;

final class Driver implements IDriver
{
    /** @var WeakMap<ISpinner, ISpinnerState> */
    protected readonly WeakMap $spinners;
    protected IInterval $interval;

    public function __construct(
        protected readonly IDriverOutput $driverOutput,
        protected readonly ITimer $timer,
        protected readonly Closure $intervalCb,
    ) {
        self::assertIntervalCallback($intervalCb);
        $this->spinners = new WeakMap();
        $this->interval = $intervalCb();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertIntervalCallback(Closure $intervalCb): void
    {
        $interval = $intervalCb();
        if ($interval instanceof IInterval) {
            return;
        }
        throw new InvalidArgumentException(
            sprintf(
                'Interval callback MUST return an instance of "%s", instead returns "%s".',
                IInterval::class,
                get_debug_type($interval)
            )
        );
    }

    public function render(float $dt = null): void
    {
        $dt ??= $this->timer->getDelta();
        foreach ($this->spinners as $spinner => $state) {
            $this->spinners->offsetSet(
                $spinner,
                $this->renderFrame(
                    $spinner->update($dt),
                    $state
                )
            );
        }
    }

    protected function renderFrame(IFrame $frame, ISpinnerState $state): ISpinnerState
    {
        $spinnerState =
            new SpinnerState(
                sequence: $frame->sequence(),
                width: $frame->width(),
                previousWidth: $state->getWidth()
            );

        $this->driverOutput->write($spinnerState);

        return $spinnerState;
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->eraseAll();
        $this->driverOutput->finalize($finalMessage);
    }

    protected function eraseAll(): void
    {
        /** @var ISpinnerState $state */
        foreach ($this->spinners as $state) {
            $this->erase($state);
        }
    }

    protected function erase(ISpinnerState $state): void
    {
        $this->driverOutput->erase($state);
    }

    public function initialize(): void
    {
        $this->driverOutput->initialize();
    }

    public function add(ISpinner $spinner): void
    {
        if (!$this->spinners->offsetExists($spinner)) {
            $this->spinners->offsetSet($spinner, new SpinnerState());
            $this->interval = $this->interval->smallest($spinner->getInterval());
        }
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function remove(ISpinner $spinner): void
    {
        if ($this->spinners->offsetExists($spinner)) {
            $this->erase($this->spinners[$spinner]);
            $this->spinners->offsetUnset($spinner);
            $this->interval = $this->recalculateInterval();
        }
    }

    protected function recalculateInterval(): IInterval
    {
        $interval = ($this->intervalCb)();
        foreach ($this->spinners as $spinner => $_) {
            $interval = $interval->smallest($spinner->getInterval());
        }
        return $interval;
    }
}
