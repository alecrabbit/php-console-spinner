<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner\Factory;

use AlecRabbit\Benchmark\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\DriverProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;

// FIXME (2023-10-23 13:0) [Alec Rabbit]: this implementation doing too much [a3f8554e-1dc8-41a9-abdf-39a6386a490b]
final class BenchmarkingDriverProviderFactory implements IDriverProviderFactory
{
    public function __construct(
        protected IBenchmarkingDriverFactory $benchmarkingDriverFactory,
        protected IDriverLinker $driverLinker,
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
            $this->benchmarkingDriverFactory
                ->create()
        ;

        $benchmarkingDriver->initialize();

        $this->driverLinker->link($benchmarkingDriver);

        return $benchmarkingDriver;
    }
}
