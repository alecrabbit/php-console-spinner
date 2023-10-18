<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Contract\Builder;

use AlecRabbit\Spinner\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Benchmark\Contract\IStopwatch;
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
