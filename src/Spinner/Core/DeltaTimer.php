<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INow;

final class DeltaTimer implements IDeltaTimer
{
    protected float $current;

    public function __construct(
        protected INow $now,
        float $startTime = 0.0,
    ) {
        $this->current = $startTime;
    }

    public function getDelta(): float
    {
        $last = $this->current;
        $this->current = $this->now->now();
        return $this->current - $last;
    }
}
