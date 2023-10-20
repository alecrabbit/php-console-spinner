<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Builder\StopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Factory\BenchmarkFactory;
use AlecRabbit\Benchmark\Factory\MeasurementFactory;
use AlecRabbit\Benchmark\Factory\StopwatchFactory;
use AlecRabbit\Benchmark\Spinner\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Spinner\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Benchmark\Stopwatch\Factory\StopwatchReportFactory;
use AlecRabbit\Benchmark\Stopwatch\Factory\StopwatchShortReportFactory;
use AlecRabbit\Benchmark\Stopwatch\MeasurementFormatter;
use AlecRabbit\Benchmark\Stopwatch\MeasurementShortFormatter;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

// values are in seconds
const RUNTIME = 600;
const TIMING_REPORT_INTERVAL = 60;
const MEMORY_REPORT_INTERVAL = 60;

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(ITimer::class, new MicrosecondTimer());
    $registry->bind(IDriverProviderFactory::class, BenchmarkingDriverProviderFactory::class);
    $registry->bind(IBenchmarkingDriverBuilder::class, BenchmarkingDriverBuilder::class);
    $registry->bind(IBenchmarkFactory::class, BenchmarkFactory::class);
    $registry->bind(IMeasurementFactory::class, MeasurementFactory::class);
    $registry->bind(IStopwatchBuilder::class, StopwatchBuilder::class);
    $registry->bind(IStopwatchFactory::class, StopwatchFactory::class);

    $container = (new ContainerFactory($registry))->getContainer();

    Facade::useContainer($container);
}

$driver = Facade::getDriver();

if (!$driver instanceof IBenchmarkingDriver) {
    throw new \LogicException(
        sprintf(
            'Driver must implement "%s".',
            IBenchmarkingDriver::class
        )
    );
}

// Create echo function
$echo =
    $driver->wrap(
        static function (?string $message = null): void {
            echo $message . PHP_EOL;
        }
    );

$benchmark = $driver->getBenchmark();
$stopwatch = $benchmark->getStopwatch();

$shortReportFactory =
    new StopwatchShortReportFactory($stopwatch, new MeasurementShortFormatter());
$finalReportFactory =
    new StopwatchReportFactory($stopwatch, new MeasurementFormatter());

// Create report functions:
$shortReport =
    static function () use ($shortReportFactory, $echo): void {
        $echo(
            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED)
            . ' '
            . $shortReportFactory->report()
        );
    };

$finalReport =
    static function () use ($finalReportFactory, $echo): void {
        $echo($finalReportFactory->report());
    };

$memoryReport =
    static function () use ($echo): void {
        static $memoryUsage = new MemoryUsage();

        $echo(
            sprintf(
                '%s %s',
                (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
                $memoryUsage->report(),
            )
        );
    };


$loop = Facade::getLoop();

// Stop loop after RUNTIME seconds
$loop
    ->delay(
        RUNTIME - 0.1,
        static function () use ($driver, $loop, $finalReport): void {
            $loop->stop();
            $driver->finalize();
            $finalReport();
        }
    )
;

// Execute short report function every TIMING_REPORT_INTERVAL seconds
$loop
    ->repeat(
        TIMING_REPORT_INTERVAL,
        $shortReport,
    )
;

// Execute memory report function every MEMORY_REPORT_INTERVAL seconds
$loop
    ->repeat(
        MEMORY_REPORT_INTERVAL,
        $memoryReport,
    )
;

$spinner = Facade::createSpinner();

// Remove spinner before loop stops
$loop
    ->delay(
        RUNTIME - 0.2,
        static function () use ($driver, $spinner): void {
            $driver->remove($spinner);
        }
    )
;

$echo(sprintf('Runtime: %ss', RUNTIME));
$echo(PHP_EOL . sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial memory report
$shortReport(); // initial timing report
