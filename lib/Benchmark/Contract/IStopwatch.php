<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use Traversable;

interface IStopwatch
{
    public function start(string $key): void;

    public function stop(string $key): void;

    /**
     * @return Traversable<string, IMeasurement>
     */
    public function getMeasurements(): Traversable;
}
