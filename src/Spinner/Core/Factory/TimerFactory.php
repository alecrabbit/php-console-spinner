<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;

final class TimerFactory implements Contract\ITimerFactory
{
    private const COEFFICIENT = 1e-6; // for milliseconds

    public function __construct(
        protected ITimerBuilder $timerBuilder,
    ) {
    }

    public function create(): ITimer
    {
        return $this->timerBuilder
            ->withStartTime(0.0)
            ->withTimeFunction(
                static fn(): float => hrtime(true) * self::COEFFICIENT // returns milliseconds
            )
            ->build()
        ;
    }
}
