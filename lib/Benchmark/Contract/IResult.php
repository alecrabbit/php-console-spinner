<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IResult
{
    public function getAverage(): int|float;

    public function getCount(): int;

    public function getMax(): int|float;

    public function getMin(): int|float;
}
