<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Benchmark\Factory\StopwatchReportFactory;
use AlecRabbit\Benchmark\Factory\StopwatchShortReportFactory;
use AlecRabbit\Benchmark\MeasurementFormatter;
use AlecRabbit\Benchmark\MeasurementShortFormatter;
use AlecRabbit\Benchmark\MicrosecondTimer;
use AlecRabbit\Benchmark\Stopwatch;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

// values are in seconds
const RUNTIME = 60;
const TIMING_REPORT_INTERVAL = 5;
const MEMORY_REPORT_INTERVAL = 60;

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(IDriverProviderFactory::class, BenchmarkingDriverProviderFactory::class);
    $registry->bind(IBenchmarkingDriverBuilder::class, BenchmarkingDriverBuilder::class);
    $registry->bind(
        IStopwatchFactory::class,
        new class implements IStopwatchFactory {
            public function create(): IStopwatch
            {
                return
                    new Stopwatch(
                        new MicrosecondTimer(),
                    );
            }
        }
    );

    $container = (new ContainerFactory($registry))->getContainer();

    Facade::setContainer($container);
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
        static function (?string $message = null) {
            echo $message . PHP_EOL;
        }
    );

$stopwatch = $driver->getStopwatch();
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


$loop = Facade::getLoop();

$loop
    ->delay(
        RUNTIME,
        static function () use ($driver, $loop, $finalReport): void {
            $loop->stop();
            $driver->finalize();
            $finalReport();
        }
    )
;

$loop
    ->repeat(
        TIMING_REPORT_INTERVAL,
        $shortReport,
    )
;


// Create memory report function
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

// Execute memory report function every MEMORY_REPORT_INTERVAL seconds
$loop
    ->repeat(
        MEMORY_REPORT_INTERVAL,
        $memoryReport
    )
;

$echo(sprintf('Runtime: %ss', RUNTIME));
$echo(PHP_EOL . sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial report

$spinner = Facade::createSpinner();
