<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;

final class DeltaTimerFactory implements Contract\IDeltaTimerFactory
{
    public function __construct(
        protected IDeltaTimerBuilder $timerBuilder,
        protected INowTimer $nowTimer,
    ) {
    }

    public function create(): IDeltaTimer
    {
        return $this->timerBuilder
            ->withStartTime(0.0)
            ->withNowTimer($this->nowTimer)
            ->build()
        ;
    }
}
