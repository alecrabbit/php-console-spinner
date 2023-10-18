<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IBenchmarkingDriver extends IDriver
{
    public function getStopwatch(): IStopwatch;
}
