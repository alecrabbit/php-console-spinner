<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IKeyFormatter
{
    public function format(string $key, ?string $prefix = null): string;
}
