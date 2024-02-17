<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

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

    abstract public function getFrame(?float $dt = null): ISequenceFrame;
}
