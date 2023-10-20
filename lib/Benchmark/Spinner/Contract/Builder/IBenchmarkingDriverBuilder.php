<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner\Contract\Builder;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;

interface IBenchmarkingDriverBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IBenchmarkingDriver;

    public function withDriver(IDriver $driver): IBenchmarkingDriverBuilder;

    public function withStopwatch(IStopwatch $stopwatch): IBenchmarkingDriverBuilder;

    public function withBenchmark(IBenchmark $benchmark): IBenchmarkingDriverBuilder;
}
