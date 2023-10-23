<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IReport
{
    public function getHeader(): string;

    public function getPrefix(): string;

    /**
     * @return iterable<string, IMeasurement>
     */
    public function getMeasurements(): iterable;
}
