<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use Closure;
use Traversable;

final class Benchmark implements IBenchmark
{
    public function __construct(
        protected readonly IStopwatch $stopwatch,
    ) {
    }

    public function run(string $key, Closure $callback, mixed ...$args): mixed
    {
        $this->stopwatch->start($key);
        $result = $callback(...$args);
        $this->stopwatch->stop($key);

        return $result;
    }

    public function getStopwatch(): IStopwatch
    {
        return $this->stopwatch;
    }

    public function getMeasurements(): Traversable
    {
        return $this->stopwatch->getMeasurements();
    }
}
