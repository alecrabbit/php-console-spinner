<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch\Contract\Factory;

use AlecRabbit\Stopwatch\Contract\IStopwatch;

interface IStopwatchFactory
{
    public function create(): IStopwatch;
}
