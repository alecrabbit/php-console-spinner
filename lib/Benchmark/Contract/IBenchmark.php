<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use Closure;

interface IBenchmark
{
    public function setPrefix(string $prefix): void;

    public function run(string $label, Closure $callback, mixed ...$args): mixed;

    public function getStopwatch(): IStopwatch;

    public function getPrefix(): string;

    public function getMeasurements(): iterable;
}
