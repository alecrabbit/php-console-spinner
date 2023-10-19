<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\A;

use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;

abstract class ATimer implements ITimer
{
    public function __construct(
        protected TimeUnit $unit,
        protected \Closure $timeFunction,
    ) {
        self::assertTimeFunction($timeFunction);
    }

    protected static function assertTimeFunction(\Closure $timeFunction): void
    {
        // TODO (2023-10-19 13:40) [Alec Rabbit]: implement assertion
    }

    public function getUnit(): TimeUnit
    {
        return $this->unit;
    }

    public function now(): int|float
    {
        return $this->timeFunction->__invoke();
    }
}
