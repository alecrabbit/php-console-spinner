<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\Factory\Contract\INowTimerFactory;

final readonly class NowTimerFactory implements INowTimerFactory, IInvokable
{
    public function __invoke(): INowTimer
    {
        return new class() implements INowTimer {
            public function now(): float
            {
                return hrtime(true) * 1e-6; // returns milliseconds
            }
        };
    }
}
