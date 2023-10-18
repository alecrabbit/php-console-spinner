<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Contract\Builder;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;

interface IBenchmarkingDriverBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IBenchmarkingDriver;

    public function withDriver(IDriver $driver): IBenchmarkingDriverBuilder;

    public function withStopwatch(IStopwatch $stopwatch): IBenchmarkingDriverBuilder;
}
