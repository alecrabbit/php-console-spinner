<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\BenchmarkingDriverBuilder;
use AlecRabbit\Tests\Helper\IBenchmarkingDriver;
use AlecRabbit\Tests\Helper\StopwatchReporter;

const RUNTIME = 600; // set runtime in seconds

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
    (static function (): callable {
        $driver = Facade::getDriver();
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
    })();

Facade::getLoop()
    ->delay(
        RUNTIME,
        static function () use ($report): void {
            Facade::getDriver()->finalize();
            Facade::getLoop()->stop();
            $report();
        }
    )
;

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
