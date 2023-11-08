<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INow;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;

final class DeltaTimerFactory implements Contract\IDeltaTimerFactory
{
    private const COEFFICIENT = 1e-6; // for milliseconds

    public function __construct(
        protected IDeltaTimerBuilder $timerBuilder,
        protected INow $now,
    ) {
    }

    public function create(): IDeltaTimer
    {
        return $this->timerBuilder
            ->withStartTime(0.0)
            ->withNow($this->now)
//            ->withTimeFunction(
//                static fn(): float => hrtime(true) * self::COEFFICIENT // returns milliseconds
//                static fn(): float => hrtime(true) * 1e-6 // returns milliseconds
//            )
            ->build()
        ;
    }
}
