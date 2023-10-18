<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Builder;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Benchmark\BenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;

final class BenchmarkingDriverBuilder implements IBenchmarkingDriverBuilder
{

    private ?IDriver $driver = null;
    private ?IStopwatch $stopwatch = null;

    public function build(): IBenchmarkingDriver
    {
        $this->validate();

        return
            new BenchmarkingDriver(
                driver: $this->driver,
                stopwatch: $this->stopwatch,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->driver === null => throw new LogicException('Driver is not set.'),
            $this->stopwatch === null => throw new LogicException('Stopwatch is not set.'),
            default => null,
        };
    }

    public function withDriver(IDriver $driver): IBenchmarkingDriverBuilder
    {
        $clone = clone $this;
        $clone->driver = $driver;
        return $clone;
    }

    public function withStopwatch(IStopwatch $stopwatch): IBenchmarkingDriverBuilder
    {
        $clone = clone $this;
        $clone->stopwatch = $stopwatch;
        return $clone;
    }
}
