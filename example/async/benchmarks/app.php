<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\Benchmark\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;
use AlecRabbit\Spinner\Helper\Benchmark\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Spinner\Helper\Benchmark\Factory\StopwatchReportFactory;
use AlecRabbit\Spinner\Helper\Benchmark\Factory\StopwatchShortReportFactory;
use AlecRabbit\Spinner\Helper\Benchmark\Stopwatch;
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
                return new Stopwatch();
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

// Create report functions:
$shortReport =
    static function () use ($stopwatch, $echo): void {
        $factory = new StopwatchShortReportFactory($stopwatch);
        $echo(
            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED)
            . ' '
            . $factory->report()
        );
    };
$finalReport =
    static function () use ($stopwatch): void {
        $factory = new StopwatchReportFactory($stopwatch);
        echo $factory->report();
    };


$loop = Facade::getLoop();

$loop
    ->delay(
        RUNTIME,
        static function () use ($driver, $loop, $finalReport): void {
            $driver->finalize();
            $loop->stop();
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

$echo(PHP_EOL . sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial report

$spinner = Facade::createSpinner();
