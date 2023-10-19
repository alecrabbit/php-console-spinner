<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IStopwatch
{
    public function start(string $label, string ...$labels): void;

    public function stop(string $label, string ...$labels): void;

    /**
     * @return iterable<IMeasurement>
     */
    public function getMeasurements(): iterable;

    public function getUnit(): TimeUnit;

    public function getRequiredMeasurements(): int;
}
