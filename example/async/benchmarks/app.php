<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\Benchmark\BenchmarkingDriverBuilder;
use AlecRabbit\Tests\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Tests\Helper\Benchmark\StopwatchReporter;

const RUNTIME = 600; // set runtime in seconds

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(IDriverBuilder::class, BenchmarkingDriverBuilder::class);

    $container = (new ContainerFactory($registry))->getContainer();

    Facade::setContainer($container);
}

$driver = Facade::getDriver();

// Create report function:
$report =
    (static function (IDriver $driver): callable {
        if (!$driver instanceof IBenchmarkingDriver) {
            throw new \LogicException(
                sprintf(
                    'Driver must implement "%s".',
                    IBenchmarkingDriver::class
                )
            );
        }
        return
            static function () use ($driver): void {
                (new StopwatchReporter($driver->getStopwatch()))->report();
            };
    })($driver);

$loop = Facade::getLoop();

$loop
    ->delay(
        RUNTIME,
        static function () use ($driver, $loop, $report): void {
            $driver->finalize();
            $loop->stop();
            $report();
        }
    )
;

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
