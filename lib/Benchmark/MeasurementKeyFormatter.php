<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IMeasurementKeyFormatter;

final class MeasurementKeyFormatter implements IMeasurementKeyFormatter
{
    public function format(string $key, ?string $prefix = null): string
    {
        // if $prefix is not null and $key begins with $prefix,
        // return $key with removed $prefix
        return
            null !== $prefix && \str_starts_with($key, $prefix)
                ? \str_replace($prefix, '', $key)
                : $key;
    }
}
