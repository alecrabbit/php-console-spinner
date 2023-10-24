<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IKeyFormatter;

final class KeyFormatter implements IKeyFormatter
{
    private const REPLACE = '';

    public function format(string $key, ?string $prefix = null): string
    {
        return
            null !== $prefix && \str_starts_with($key, $prefix)
                ? \str_replace($prefix, self::REPLACE, $key)
                : $key;
    }
}
