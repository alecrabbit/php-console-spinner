<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use AlecRabbit\Benchmark\Benchmark;

interface IBenchmark
{
    public function setPrefix(string $prefix): void;

    public function run(string $label, \Closure $callback, mixed ...$args): mixed;

    public function getStopwatch(): IStopwatch;
}
