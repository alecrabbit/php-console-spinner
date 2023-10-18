<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark\Contract;

interface IStopwatch
{
    public function start(string $label, string ...$labels): void;

    public function stop(string $label, string ...$labels): void;

    public function getMeasurements(): iterable;
}
