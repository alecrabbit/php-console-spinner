<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\BenchmarkingDriverBuilder;
use AlecRabbit\Tests\Helper\IBenchmarkingDriver;
use AlecRabbit\Tests\Helper\StopwatchReporter;

const RUNTIME = 20; // set runtime in seconds

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(IDriverBuilder::class, BenchmarkingDriverBuilder::class);

    $container = (new ContainerFactory($registry))->getContainer();

    Facade::setContainer($container);
}

// Create report function:
$report =
    static function (IDriver $driver): void {
        if (!$driver instanceof IBenchmarkingDriver) {
            throw new \LogicException('Driver must implement IBenchmarkingDriver');
        }
        (new StopwatchReporter($driver->getStopwatch()))->report();
    };

$loop = Facade::getLoop();

$loop->delay(
    RUNTIME,
    static function () use ($loop, $report): void {
        $driver = Facade::getDriver();

        $driver->finalize();
        $loop->stop();
        $report($driver);
    }
);

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
