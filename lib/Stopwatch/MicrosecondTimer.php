<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch;

use AlecRabbit\Stopwatch\A\ATimer;
use AlecRabbit\Stopwatch\Contract\TimeUnit;

use Closure;

use function microtime;

final class MicrosecondTimer extends ATimer
{
    private const UNIT = TimeUnit::MICROSECOND;

    public function __construct(
        TimeUnit $unit = self::UNIT,
        Closure $timeFunction = null,
    ) {
        if (null === $timeFunction) {
            $timeFunction =
                static fn(): float => microtime(true) * 1_000_000; // microseconds
        }
        parent::__construct($unit, $timeFunction);
    }
}
