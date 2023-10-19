<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\A\ATimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;

final class MicrosecondTimer extends ATimer
{
    protected const UNIT = TimeUnit::MICROSECOND;

    public function __construct(
        TimeUnit $unit = self::UNIT,
        \Closure $timeFunction = null,
    ) {
        if (null === $timeFunction) {
            $timeFunction =
                static fn(): float => \microtime(true) * 1_000_000; // microseconds
        }
        parent::__construct($unit, $timeFunction);
    }
}
