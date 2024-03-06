<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Lib\Helper\MemoryUsage;
use AlecRabbit\Lib\Spinner\BenchmarkFacade;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Probes;
use AlecRabbit\Spinner\Facade;

const CYCLES = 2_000_000;
const PROGRESS_EVERY_CYCLES = CYCLES / 10;

require __DIR__ . '/../container.sync.php';

// unregister all loop probes
Probes::unregister(ILoopProbe::class);

$driver = Facade::getDriver();

if (!$driver instanceof IBenchmarkingDriver) {
    throw new LogicException(
        sprintf(
            'Driver must implement "%s".',
            IBenchmarkingDriver::class
        )
    );
}

$memoryUsage = new MemoryUsage();

$spinner = Facade::createSpinner();

// Do benchmarking:
for ($i = 0; $i < CYCLES; $i++) {
    if ($i % PROGRESS_EVERY_CYCLES === 0) {
        echo sprintf(
            '%s %s',
            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
            $memoryUsage->report(),
        );
        echo '  ';
        echo sprintf(
            '%s%% [%d/%d]',
            (int)ceil(100 * $i / CYCLES),
            $i,
            CYCLES
        );
        echo PHP_EOL;
    }

    $driver->render();
}
echo PHP_EOL;

// call other methods:
$driver->remove($spinner);
$driver->getInterval();
$driver->wrap(static fn() => null);

// Finalize:
$driver->finalize();

// Print report:
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

$title = sprintf('%s cycles', CYCLES);

$reportObject =
    (new ReportFactory(benchmarkResults: $benchmarkResults, title: $title))
        ->create()
;

$reportPrinter->print($reportObject);
