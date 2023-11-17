<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IKeyFormatter;

use function str_replace;
use function str_starts_with;

final class KeyFormatter implements IKeyFormatter
{
    private const REPLACE = '';

    public function format(string $key, ?string $prefix = null): string
    {
        return $prefix !== null && str_starts_with($key, $prefix)
            ? str_replace($prefix, self::REPLACE, $key)
            : $key;
    }
}
