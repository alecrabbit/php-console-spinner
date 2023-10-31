<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IBenchmark;

interface IBenchmarkFactory
{
    public function create(): IBenchmark;
}
