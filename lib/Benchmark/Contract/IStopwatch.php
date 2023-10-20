<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IStopwatch
{
    public function start(string $key): void;

    public function stop(string $key): void;

    /**
     * @return iterable<IMeasurement>
     */
    public function getMeasurements(): iterable;

    /** @deprecated */
    public function getUnit(): TimeUnit;

    /** @deprecated */
    public function getRequiredMeasurements(): int;
}
