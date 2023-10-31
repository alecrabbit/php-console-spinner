<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;
use AlecRabbit\Spinner\Probes;

// in seconds
const RUNTIME = 600;
const MEMORY_REPORT_INTERVAL = 60;

$container = require __DIR__ . '/../bootstrap.php';

// Pick ONE of the following event loops:
Probes::unregister(\AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe::class);
//Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe::class);

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


/** @var IBenchmarkResultsFactory $benchmarkResultsFactory */
$benchmarkResultsFactory = $container->get(IBenchmarkResultsFactory::class);

$benchmarkResults =
    $benchmarkResultsFactory
        ->create(
            $driver
                ->getBenchmark()
                ->getMeasurements()
        )
;


// Create report function:
$reportPrinter = $container->get(IReportPrinter::class);

$reportObject =
    (new ReportFactory(benchmarkResults: $benchmarkResults, title: 'Benchmarking'))
        ->create()
;

$fullReport =
    static function () use ($reportPrinter, $reportObject): void {
        $reportPrinter->print($reportObject);
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
        static function () use ($driver, $loop, $fullReport): void {
            $loop->stop();
            $driver->finalize();
            $fullReport();
        }
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

// Begin benchmarking
$echo(sprintf('Runtime: %ss', RUNTIME));
$echo();
$echo(sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial memory report
