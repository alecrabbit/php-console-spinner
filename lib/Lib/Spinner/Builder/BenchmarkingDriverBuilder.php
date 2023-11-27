<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Builder;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Lib\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Lib\Spinner\Core\BenchmarkingDriver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;

final class BenchmarkingDriverBuilder implements IBenchmarkingDriverBuilder
{
    private ?IDriver $driver = null;
    private ?IBenchmark $benchmark = null;

    public function build(): IBenchmarkingDriver
    {
        $this->validate();

        return new BenchmarkingDriver(
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

    public function withBenchmark(IBenchmark $benchmark): IBenchmarkingDriverBuilder
    {
        $clone = clone $this;
        $clone->benchmark = $benchmark;
        return $clone;
    }
}
