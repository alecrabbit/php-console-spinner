<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark\Contract;

use AlecRabbit\Tests\Helper\Benchmark\Measurement;
use LogicException;

interface IMeasurement
{
    public function getAverage(): int|float;
    public function getMin(): int|float;
    public function getMax(): int|float;

    public function add(int $value): void;

    public function getCount(): int;
}
