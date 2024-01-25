<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;

abstract class ARevolver implements IRevolver
{
    protected readonly int $deltaTolerance;
    protected float $diff;
    protected readonly float $intervalValue;

    public function __construct(
        protected IInterval $interval,
        protected ITolerance $tolerance = new Tolerance(),
    ) {
        $this->deltaTolerance = $this->tolerance->toMilliseconds();
        $this->diff = $this->intervalValue = $interval->toMilliseconds();
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->shouldUpdate($dt)) {
            $this->next($dt);
        }
        return $this->current();
    }

    protected function shouldUpdate(?float $dt = null): bool
    {
        if ($dt === null || $this->intervalValue <= ($dt + $this->deltaTolerance) || $this->diff <= 0) {
            $this->diff = $this->intervalValue;
            return true;
        }
        $this->diff -= $dt;
        return false;
    }

    abstract protected function next(?float $dt = null): void;

    abstract protected function current(): IFrame;
}
