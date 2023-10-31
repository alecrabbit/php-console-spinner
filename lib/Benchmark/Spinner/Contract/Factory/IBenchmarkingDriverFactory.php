<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner\Contract\Factory;

use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;

interface IBenchmarkingDriverFactory extends IDriverFactory
{
    public function create(): IBenchmarkingDriver;
}
