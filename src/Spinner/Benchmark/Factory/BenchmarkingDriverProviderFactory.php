<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Factory;

use AlecRabbit\Spinner\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Spinner\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\DriverProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;

final class BenchmarkingDriverProviderFactory implements IDriverProviderFactory
{
    public function __construct(
        protected IDriverFactory $driverFactory,
        protected IDriverLinker $linker,
        protected IBenchmarkingDriverBuilder $benchmarkingDriverBuilder,
        protected IStopwatchFactory $stopwatchFactory,
    ) {
    }

    public function create(): IDriverProvider
    {
        return
            new DriverProvider(
                driver: $this->createDriver(),
            );
    }

    protected function createDriver(): IDriver
    {
        $benchmarkingDriver =
            $this->benchmarkingDriverBuilder
                ->withDriver($this->driverFactory->create())
                ->withStopwatch($this->stopwatchFactory->create())
                ->build()
        ;

        $benchmarkingDriver->initialize();

        $this->linker->link($benchmarkingDriver);

        return $benchmarkingDriver;
    }
}
