<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Benchmark;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;

final class BenchmarkFactory implements IBenchmarkFactory
{
    public function create(): IBenchmark
    {
        return new Benchmark();
    }
}
