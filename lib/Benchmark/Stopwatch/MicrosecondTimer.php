<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Stopwatch\A\ATimer;
use Closure;

use function microtime;

final class MicrosecondTimer extends ATimer
{
    private const UNIT = TimeUnit::MICROSECOND;

    public function __construct(
        TimeUnit $unit = self::UNIT,
        ?Closure $timeFunction = null,
    ) {
        if ($timeFunction === null) {
            $timeFunction =
                static fn(): float => microtime(true) * 1_000_000; // microseconds
        }
        parent::__construct($unit, $timeFunction);
    }
}
