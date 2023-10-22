<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IMeasurement;

interface IMeasurementFactory
{
    public function create(): IMeasurement;
}
