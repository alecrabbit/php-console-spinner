<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

enum TimeUnit: string
{
    case NANOSECOND = 'ns';
    case MICROSECOND = 'μs';
    case MILLISECOND = 'ms';
    case SECOND = 's';
    case MINUTE = 'm';
    case HOUR = 'h';
}
