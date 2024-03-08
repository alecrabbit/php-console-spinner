<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

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
        return new RandomDeltaTimer();
    }
}
