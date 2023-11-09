<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Probes;

const CYCLES = 2_000_000;
const PROGRESS_EVERY_CYCLES = CYCLES / 10;

$container = require __DIR__ . '/container.sync.php';

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

$spinner = Facade::createSpinner();


// Do benchmarking:
for ($i = 0; $i < CYCLES; $i++) {
    if ($i % PROGRESS_EVERY_CYCLES === 0) {
        echo sprintf(
                '%s%% [%d/%d]',
                (int)ceil(100 * $i / CYCLES),
                $i,
                CYCLES
            ) . PHP_EOL;
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

$reportPrinter = $container->get(IReportPrinter::class);

$title = sprintf('%s cycles', CYCLES);

$reportObject =
    (new ReportFactory(benchmarkResults: $benchmarkResults, title: $title))
        ->create()
;

$reportPrinter->print($reportObject);
