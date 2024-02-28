<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;

final class DeltaTimer implements IDeltaTimer
{
    private float $current;

    public function __construct(
        private readonly INowTimer $nowTimer,
        float $startTime = 0.0,
    ) {
        $this->current = $startTime;
    }

    public function getDelta(): float
    {
        $previous = $this->current;
        $this->current = $this->nowTimer->now();
        return $this->current - $previous;
    }
}
