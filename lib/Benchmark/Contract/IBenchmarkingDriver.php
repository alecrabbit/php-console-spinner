<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Stopwatch\Contract\IStopwatch;

interface IBenchmarkingDriver extends IDriver
{
    public function getStopwatch(): IStopwatch;
}
