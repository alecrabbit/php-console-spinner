<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Lib\Helper\MemoryUsage;
use AlecRabbit\Lib\Spinner\BenchmarkFacade;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Probes;
use AlecRabbit\Spinner\Facade;

// in seconds
const RUNTIME = 600;
const MEMORY_REPORT_INTERVAL = 60;

require __DIR__ . '/../container.php';

// Pick ONE of the following event loops:
Probes::unregister(ReactLoopProbe::class);
//Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe::class);

$driver = Facade::getDriver();

if (!$driver instanceof IBenchmarkingDriver) {
    throw new LogicException(
        sprintf(
            'Driver must implement "%s".',
            IBenchmarkingDriver::class
        )
    );
}

$benchmarkResultsFactory = BenchmarkFacade::getBenchmarkResultsFactory();

$benchmarkResults =
    $benchmarkResultsFactory
        ->create(
            $driver
                ->getBenchmark()
                ->getMeasurements()
        )
;

$reportPrinter = BenchmarkFacade::getReportPrinter();

$reportObject =
    (new ReportFactory(benchmarkResults: $benchmarkResults, title: 'Benchmarking'))
        ->create()
;

$fullReport =
    static function () use ($reportPrinter, $reportObject): void {
        $reportPrinter->print($reportObject);
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
echo sprintf('Runtime: %ss', RUNTIME) .PHP_EOL;
