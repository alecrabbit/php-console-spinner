<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use Traversable;

interface IBenchmarkResultsFactory
{
    /**
     * @param Traversable<string, IMeasurement> $measurements
     */
    public function create(Traversable $measurements): IBenchmarkResults;
}
