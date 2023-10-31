<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IResult;

final class Result implements IResult
{
    public function __construct(
        protected int|float $average,
        protected int|float $min,
        protected int|float $max,
        protected int $count,
    ) {
    }

    public function getAverage(): int|float
    {
        return $this->average;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getMin(): int|float
    {
        return $this->min;
    }

    public function getMax(): int|float
    {
        return $this->max;
    }
}
