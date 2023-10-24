<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use AlecRabbit\Benchmark\Exception\MeasurementException;

interface IMeasurement
{
    public function add(int|float $value): void;

    /** @throws MeasurementException */
    public function getAverage(): int|float;

    /** @throws MeasurementException */
    public function getAny(): int|float;

    public function getCount(): int;

    /** @throws MeasurementException */
    public function getMax(): int|float;

    /** @throws MeasurementException */
    public function getMin(): int|float;

    public function getThreshold(): int;
}
