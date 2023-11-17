<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Benchmark;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;

final readonly class BenchmarkFactory implements IBenchmarkFactory
{
    public function __construct(
        protected IStopwatchFactory $stopwatchFactory,
    ) {
    }

    public function create(): IBenchmark
    {
        return new Benchmark(
            $this->stopwatchFactory->create(),
        );
    }
}
