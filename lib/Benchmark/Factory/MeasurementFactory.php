<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Stopwatch\Measurement;

final class MeasurementFactory implements IMeasurementFactory
{
    public function create(): IMeasurement
    {
        return new Measurement();
    }
}
