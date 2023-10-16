<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\BenchmarkingDriver;
use AlecRabbit\Tests\Helper\BenchmarkingDriverBuilder;

const RUNTIME = 20; // set runtime in seconds

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container with custom one:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(IDriverBuilder::class, BenchmarkingDriverBuilder::class);

    $container = (new ContainerFactory($registry))->getContainer();

    Facade::setContainer($container);
}


$driver = Facade::getDriver();
$loop = Facade::getLoop();

$loop->delay(
    RUNTIME, // stop loop at
    static function () use ($driver, $loop): void {
        $driver->finalize();
        $loop->stop();
        if ($driver instanceof BenchmarkingDriver) {
            $driver->report();
        }
    }
);

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
