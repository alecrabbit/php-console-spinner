<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Contract;

interface IMeasurementFormatter
{
    public function format(IMeasurement $measurement): string;
}
