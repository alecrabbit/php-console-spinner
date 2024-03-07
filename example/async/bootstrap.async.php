<?php

declare(strict_types=1);

use AlecRabbit\Lib\Helper\MemoryUsage;
use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedLoopProviderFactory;
use AlecRabbit\Lib\Spinner\Core\Factory\DecoratedLoopProviderFactory;
use AlecRabbit\Lib\Spinner\Factory\DecoratedDriverLinkerFactory;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Facade;

const MEMORY_REPORT_INTERVAL = 60; // seconds

// Code in this file is NOT REQUIRED
// and is used only for demonstration convenience.
require_once __DIR__ . '/../bootstrap.php'; // <-- except this line - it is required 🙂

$registry = DefinitionRegistry::getInstance();

// Replace default driver linker with decorated driver linker(outputs some debug info)
$registry->bind(
    new ServiceDefinition(
        IDriverLinker::class,
        new Reference(IDecoratedDriverLinkerFactory::class),
        IServiceDefinition::SINGLETON,
    ),
    new ServiceDefinition(IDecoratedDriverLinkerFactory::class, DecoratedDriverLinkerFactory::class),
    new ServiceDefinition(
        ILoopProvider::class,
        new Reference(IDecoratedLoopProviderFactory::class),
        IServiceDefinition::SINGLETON | IServiceDefinition::PUBLIC,
    ),
    new ServiceDefinition(IDecoratedLoopProviderFactory::class, DecoratedLoopProviderFactory::class),
);

register_shutdown_function(
    static function (): void {
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

        // Schedule memory report function
        $loop
            ->repeat(
                MEMORY_REPORT_INTERVAL,
                $memoryReport
            )
        ;

        // Schedule initial memory report immediately after loop start
        $loop
            ->delay(
                0,
                $memoryReport
            )
        ;
    }
);
