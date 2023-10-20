<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Contract\Factory;

use AlecRabbit\Benchmark\Stopwatch\Contract\IStopwatch;

interface IStopwatchFactory
{
    public function create(): IStopwatch;
}
