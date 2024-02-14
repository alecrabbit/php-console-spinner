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

    abstract public function getFrame(?float $dt = null): IFrame;
}
