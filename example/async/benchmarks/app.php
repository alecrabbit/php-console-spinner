<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\Benchmark\BenchmarkingDriverBuilder;
use AlecRabbit\Tests\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Tests\Helper\Benchmark\StopwatchReportFactory;
use AlecRabbit\Tests\Helper\Benchmark\StopwatchShortReportFactory;

const RUNTIME = 30; // set runtime in seconds
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

// Create echo function
$echo =
    $driver->wrap(
        static function (?string $message = null) {
            echo $message . PHP_EOL;
        }
    );

// Create report function:
$finalReport =
    (static function (IDriver $driver): callable {
        if (!$driver instanceof IBenchmarkingDriver) {
            throw new \LogicException(
                sprintf(
                    'Driver must implement "%s".',
                    IBenchmarkingDriver::class
                )
            );
        }
        
        $factory = new StopwatchReportFactory($driver->getStopwatch());
        
        return
            static function () use ($factory): void {
                echo $factory->report();
            };
    })(
        $driver
    );

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

$factory = new StopwatchShortReportFactory($driver->getStopwatch());

$loop
    ->repeat(
        INTERVAL,
        static function () use ($factory, $echo): void {
            $echo(
                (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED)
                . ' '
                . $factory->report()
            );
        }
    )
;
$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
