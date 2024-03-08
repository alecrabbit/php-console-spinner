<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Factory\ITimerFactory;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Spinner\Contract\IInvokable;

final readonly class MicrosecondTimerFactory implements ITimerFactory, IInvokable
{
    public function __invoke(): ITimer
    {
        return $this->create();
    }

    public function create(): ITimer
    {
        return new MicrosecondTimer();
    }
}
