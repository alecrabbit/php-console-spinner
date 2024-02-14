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
    public function __construct(
        protected IInterval $interval,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    abstract public function getFrame(?float $dt = null): IFrame;
}
