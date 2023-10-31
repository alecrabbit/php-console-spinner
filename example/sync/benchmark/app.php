<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Probes;

const CYCLES = 200000;
const PROGRESS_EVERY_CYCLES = CYCLES / 10;

require_once __DIR__ . '/../../benchmark/bootstrap.php';

// unregister all loop probes
Probes::unregister(\AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe::class);
Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe::class);

// Replace container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(
        IResourceStream::class,
        new class implements IResourceStream {
            public function write(Traversable $data): void
            {
                // unwrap data
                iterator_to_array($data);
            }
        }
    );
    $registry->bind(
        ITimer::class,
        new class implements ITimer {
            public function getDelta(): float
            {
                // simulate unequal time intervals
                return (float)random_int(1000, 500000);
            }
        }
    );

    $container = (new ContainerFactory($registry))->create();

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

$spinner = Facade::createSpinner();


// Do benchmarking:
for ($i = 0; $i < CYCLES; $i++) {
    if ($i % PROGRESS_EVERY_CYCLES === 0) {
        echo sprintf(
                '%s%%, cycle: %d/%d',
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
