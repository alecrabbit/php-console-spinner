<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IMeasurement
{
    public function add(int|float $value): void;

    public function getAverage(): int|float;

    public function getAny(): int|float;

    public function getCount(): int;

    public function getMax(): int|float;

    public function getMin(): int|float;

    public function getThreshold(): int;
}
