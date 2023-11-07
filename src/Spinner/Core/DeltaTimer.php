<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INow;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Closure;
use ReflectionFunction;
use Throwable;

final class DeltaTimer implements IDeltaTimer
{
    public function __construct(
        protected INow $now,
        protected float $time = 0.0,
    ) {
    }

    public function getDelta(): float
    {
        $last = $this->time;
        $this->time = $this->now->now();
        return $this->time - $last;
    }
}
