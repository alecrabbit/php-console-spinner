<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner\Builder;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Spinner\BenchmarkingDriver;
use AlecRabbit\Benchmark\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;

final class BenchmarkingDriverBuilder implements IBenchmarkingDriverBuilder
{

    private ?IDriver $driver = null;
    private ?IStopwatch $stopwatch = null;
    private ?IBenchmark $benchmark = null;

    public function build(): IBenchmarkingDriver
    {
        $this->validate();

        return
            new BenchmarkingDriver(
                driver: $this->driver,
                benchmark: $this->benchmark,
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
            $this->benchmark === null => throw new LogicException('Benchmark is not set.'),
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

    public function withBenchmark(IBenchmark $benchmark): IBenchmarkingDriverBuilder
    {
        $clone = clone $this;
        $clone->benchmark = $benchmark;
        return $clone;
    }
}
