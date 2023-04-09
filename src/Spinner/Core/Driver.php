<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use WeakMap;

final class Driver implements IDriver
{
    /** @var WeakMap<ISpinner, int> */
    protected WeakMap $spinners;
    protected bool $initialized = false;
    protected IInterval $interval;

    public function __construct(
        protected readonly IDriverOutput $driverOutput,
        protected readonly ITimer $timer,
        protected \Closure $intervalCb,
    ) {
        self::assertIntervalCallback($intervalCb);
        $this->spinners = new WeakMap();
        $this->interval = $intervalCb();
    }

    protected static function assertIntervalCallback(\Closure $intervalCb): void
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
        foreach ($this->spinners as $spinner => $previousWidth) {
            if ($this->initialized) {
                $this->spinners[$spinner] =
                    $this->renderFrame(
                        $spinner->update($dt),
                        $previousWidth
                    );
            }
        }
    }

    protected function renderFrame(IFrame $frame, int $previousWidth): int
    {
        $width = $frame->width();

        $this->driverOutput->writeSequence($frame->sequence(), $width, $previousWidth);

        return $width;
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        if ($this->initialized) {
            $this->eraseAll();
            $this->driverOutput->finalize($finalMessage);
        }
    }

    protected function eraseAll(): void
    {
        foreach ($this->spinners as $spinner => $_) {
            $this->erase($spinner);
        }
    }

    protected function erase(ISpinner $spinner): void
    {
        if ($this->initialized) {
            $this->driverOutput->erase($this->spinners[$spinner]);
        }
    }

    public function initialize(): void
    {
        $this->driverOutput->initialize();
        $this->initialized = true;
    }

    public function add(ISpinner $spinner): void
    {
        if (!$this->spinners->offsetExists($spinner)) {
            $this->spinners->offsetSet($spinner, 0);
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
            $this->erase($spinner);
            $this->spinners->offsetUnset($spinner);
            $this->recalculateInterval();
        }
    }

    protected function recalculateInterval(): void
    {
        $this->interval = ($this->intervalCb)();
        foreach ($this->spinners as $spinner => $_) {
            $this->interval = $this->interval->smallest($spinner->getInterval());
        }
    }
}
