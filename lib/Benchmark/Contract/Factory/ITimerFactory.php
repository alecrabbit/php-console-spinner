<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\ITimer;

interface ITimerFactory
{
    public function create(): ITimer;
}
