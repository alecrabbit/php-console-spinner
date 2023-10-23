<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use AlecRabbit\Benchmark\DatetimeFormatter;

interface IDatetimeFormatter
{
    public function format(\DateTimeInterface $datetime, string $format = null): string;
}
