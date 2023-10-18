<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Contract;

interface IMeasurement
{
    public function getAverage(): int|float;

    public function getMin(): int|float;

    public function getMax(): int|float;

    public function add(int|float $value): void;

    public function getCount(): int;
}
