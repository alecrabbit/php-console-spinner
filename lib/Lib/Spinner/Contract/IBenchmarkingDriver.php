<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IBenchmarkingDriver extends IDriver
{
    public function getBenchmark(): IBenchmark;
}
