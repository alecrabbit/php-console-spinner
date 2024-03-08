<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Benchmark\Core\RandomDeltaTimer;
use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;

final class RandomDeltaTimerFactory implements IDeltaTimerFactory, IInvokable
{
    public function __invoke(): IDeltaTimer
    {
        return $this->create();
    }

    public function create(): IDeltaTimer
    {
        return new class() implements IDeltaTimer {
            public function getDelta(): float
            {
                // simulate unequal time intervals
                return (float)random_int(1000, 500000);
            }
        };
    }
}
