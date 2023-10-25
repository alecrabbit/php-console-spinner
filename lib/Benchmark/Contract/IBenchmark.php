<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use Closure;
use Traversable;

interface IBenchmark
{
    public function run(string $key, Closure $callback, mixed ...$args): mixed;

    /** @deprecated */
    public function getStopwatch(): IStopwatch;

    public function getMeasurements(): Traversable;
}
