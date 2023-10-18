<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Contract\Factory;

use AlecRabbit\Spinner\Benchmark\Contract\IStopwatch;

interface IStopwatchFactory
{
    public function create(): IStopwatch;
}
