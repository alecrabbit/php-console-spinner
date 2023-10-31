<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use DateTimeInterface;

interface IDatetimeFormatter
{
    public function format(DateTimeInterface $datetime): string;
}
