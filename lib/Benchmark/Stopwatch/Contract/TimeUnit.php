<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Contract;

enum TimeUnit: string
{
    case NANOSECOND = 'ns';
    case MICROSECOND = 'μs';
    case MILLISECOND = 'ms';
    case SECOND = 's';
    case MINUTE = 'm';
    case HOUR = 'h';
}
