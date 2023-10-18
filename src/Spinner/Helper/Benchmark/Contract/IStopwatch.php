<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Contract;

interface IStopwatch
{
    public function start(string $label, string ...$labels): void;

    public function stop(string $label, string ...$labels): void;

    /**
     * @return iterable<IMeasurement>
     */
    public function getMeasurements(): iterable;

    public function getUnits(): string;

    public function getRequiredMeasurements(): int;
}
