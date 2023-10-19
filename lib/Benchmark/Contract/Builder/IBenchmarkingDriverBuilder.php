<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Builder;

use AlecRabbit\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Contract\IStopwatch;
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
}
