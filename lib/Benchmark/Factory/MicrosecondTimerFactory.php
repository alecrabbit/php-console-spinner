<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Spinner\Contract\IInvokable;

final readonly class MicrosecondTimerFactory implements IInvokable
{
    public function __invoke(): ITimer
    {
        return new MicrosecondTimer();
    }
}
