<?php

declare(strict_types=1);

use AlecRabbit\Lib\Helper\MemoryUsage;
use AlecRabbit\Lib\Spinner\Contract\Factory\IDriverLinkerWithOutputFactory;
use AlecRabbit\Lib\Spinner\Factory\DriverLinkerWithOutputFactory;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Facade;

const MEMORY_REPORT_INTERVAL = 60; // seconds

// Code in this file is NOT REQUIRED
// and is used only for demonstration convenience.
require_once __DIR__ . '/../bootstrap.php'; // <-- except this line - it is required 🙂

$registry = DefinitionRegistry::getInstance();

// Replace default driver linker with driver linker with output
$registry->bind(
    new ServiceDefinition(
        IDriverLinker::class,
        static function (IContainer $container): IDriverLinker {
            return $container->get(IDriverLinkerWithOutputFactory::class)->create();
        },
        IServiceDefinition::SINGLETON,
    ),
);

// Register driver linker with output factory
$registry->bind(
    new ServiceDefinition(IDriverLinkerWithOutputFactory::class, DriverLinkerWithOutputFactory::class),
);

$container = (new ContainerFactory($registry))->create();

Facade::useContainer($container);

$driver = Facade::getDriver();

// Create echo function
$echo =
    $driver->wrap(
        static function (?string $message = null): void {
            echo $message . PHP_EOL;
        }
    );

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

$loop = Facade::getLoop();

// Execute memory report function every $reportInterval seconds
$loop
    ->repeat(
        MEMORY_REPORT_INTERVAL,
        $memoryReport
    )
;

$echo(PHP_EOL . sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial report
