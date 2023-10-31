<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;

final class BenchmarkingDriverFactory implements IBenchmarkingDriverFactory
{
    public function __construct(
        protected IBenchmarkingDriverBuilder $benchmarkingDriverBuilder,
        protected IBenchmarkFactory $benchmarkFactory,
        protected IDriverFactory $driverFactory,
    ) {
    }

    public function create(): IBenchmarkingDriver
    {
        return
            $this->benchmarkingDriverBuilder
                ->withDriver($this->driverFactory->create())
                ->withBenchmark($this->benchmarkFactory->create())
                ->build()
        ;
    }
}
