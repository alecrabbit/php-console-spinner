<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Helper\Benchmark\BenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Spinner\Helper\Benchmark\Stopwatch;

final class BenchmarkingDriverFactory implements IBenchmarkingDriverFactory
{
    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IIntervalFactory $intervalFactory,
        protected IDriverOutputFactory $driverOutputFactory,
        protected ITimerFactory $timerFactory,
    ) {
    }

    public function create(): IDriver
    {
        $driver = $this->driverBuilder
            ->withDriverOutput(
                $this->driverOutputFactory->create()
            )
            ->withTimer(
                $this->timerFactory->create()
            )
            ->withInitialInterval(
                $this->intervalFactory->createStill()
            )
            ->build()
        ;

        return
            new BenchmarkingDriver(
                driver: $driver,
                stopwatch: new Stopwatch(),
            );
    }
}
