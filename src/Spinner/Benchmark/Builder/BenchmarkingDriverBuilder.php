<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Builder;

use AlecRabbit\Spinner\Benchmark\BenchmarkingDriver;
use AlecRabbit\Spinner\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Spinner\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Benchmark\Contract\IStopwatch;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;

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
