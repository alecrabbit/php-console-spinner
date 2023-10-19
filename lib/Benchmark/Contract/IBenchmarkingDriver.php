<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IBenchmarkingDriver extends IDriver
{
    public function getStopwatch(): IStopwatch;
}
