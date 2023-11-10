<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;

final readonly class DeltaTimerFactory implements IDeltaTimerFactory
{
    public function __construct(
        private IDeltaTimerBuilder $timerBuilder,
        private INowTimer $nowTimer,
        private float $startTime = 0.0,
    ) {
    }

    public function create(): IDeltaTimer
    {
        return
            $this->timerBuilder
                ->withStartTime($this->startTime)
                ->withNowTimer($this->nowTimer)
                ->build()
        ;
    }
}
