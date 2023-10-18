<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\Benchmark\BenchmarkingDriverBuilder;
use AlecRabbit\Tests\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Tests\Helper\Benchmark\StopwatchReportFactory;
use AlecRabbit\Tests\Helper\Benchmark\StopwatchShortReportFactory;

const RUNTIME = 600; // set runtime in seconds
const INTERVAL = 5; // Timing report interval in seconds

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(IDriverBuilder::class, BenchmarkingDriverBuilder::class);

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
        INTERVAL,
        $shortReport,
    )
;

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
