<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Contract\Factory;

use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;

interface IStopwatchFactory
{
    public function create(): IStopwatch;
}
