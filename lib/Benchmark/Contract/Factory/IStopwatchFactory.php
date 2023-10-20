<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IStopwatch;

interface IStopwatchFactory
{
    public function create(): IStopwatch;
}
