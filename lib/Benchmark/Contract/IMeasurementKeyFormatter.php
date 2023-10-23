<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IMeasurementKeyFormatter
{
    public function format(string $key, ?string $prefix = null): string;
}
