<?php

declare(strict_types=1);

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedLoopProviderFactory;
use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\Contract\ILoopInfoFormatter;
use AlecRabbit\Lib\Spinner\Contract\ILoopInfoPrinter;
use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReporter;
use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReportPrinter;
use AlecRabbit\Lib\Spinner\Core\Factory\DecoratedLoopProviderFactory;
use AlecRabbit\Lib\Spinner\DriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Factory\DecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Factory\MemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\IntervalFormatter;
use AlecRabbit\Lib\Spinner\LoopInfoFormatter;
use AlecRabbit\Lib\Spinner\LoopInfoPrinter;
use AlecRabbit\Lib\Spinner\MemoryUsageReporter;
use AlecRabbit\Lib\Spinner\MemoryUsageReportPrinter;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

// Code in this file is NOT REQUIRED
// and is used only for demonstration convenience.
require_once __DIR__ . '/../bootstrap.php'; // <-- except this line - it is required 🙂

$registry = DefinitionRegistry::getInstance();

// Replace services with decorated ones (to output some info)
$registry->bind(
    // DriverLinker
    new ServiceDefinition(
        IDriverLinker::class,
        new Reference(IDecoratedDriverLinkerFactory::class),
        IServiceDefinition::SINGLETON,
    ),
    new ServiceDefinition(IDecoratedDriverLinkerFactory::class, DecoratedDriverLinkerFactory::class),
    new ServiceDefinition(IDriverInfoPrinter::class, DriverInfoPrinter::class),
    new ServiceDefinition(IIntervalFormatter::class, IntervalFormatter::class),
    // LoopProvider
    new ServiceDefinition(
        ILoopProvider::class,
        new Reference(IDecoratedLoopProviderFactory::class),
        IServiceDefinition::SINGLETON | IServiceDefinition::PUBLIC,
    ),
    new ServiceDefinition(IDecoratedLoopProviderFactory::class, DecoratedLoopProviderFactory::class),
    new ServiceDefinition(ILoopInfoPrinter::class, LoopInfoPrinter::class),
    new ServiceDefinition(ILoopInfoFormatter::class, LoopInfoFormatter::class),
    new ServiceDefinition(IMemoryUsageReporter::class, MemoryUsageReporter::class),
    new ServiceDefinition(IMemoryUsageReportPrinter::class, MemoryUsageReportPrinter::class),
    new ServiceDefinition(IMemoryReportSetupFactory::class, MemoryReportSetupFactory::class),
);
