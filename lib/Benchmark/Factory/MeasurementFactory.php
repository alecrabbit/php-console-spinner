<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Stopwatch\Measurement;

final class MeasurementFactory implements IMeasurementFactory
{
    private TimeUnit $unit;

    public function __construct(
        ITimer $timer,
    ) {
        $this->unit = $timer->getUnit();
    }

    public function create(): IMeasurement
    {
        return
            new Measurement(
                unit: $this->unit,
            );
    }
}
