<?php

declare(strict_types=1);

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\AbstractDumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;
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
require_once __DIR__ . '/../vendor/autoload.php'; // <-- except this line - it is required 🙂

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

if (class_exists(NunoMaduro\Collision\Provider::class)) {
    // // Note: interferes with event-loop autostart in case of exception
    (new NunoMaduro\Collision\Provider())->register(); // see [889ad594-ca28-4770-bb38-fd5bd8cb1777]
}

if (class_exists(Symfony\Component\VarDumper\VarDumper::class)) {
    $cloner = new VarCloner();

    $dumper =
        new ServerDumper(
            getHost(),
            getDumper(),
            [
                'cli' => new CliContextProvider(),
                'source' => new SourceContextProvider(),
            ]
        );

    VarDumper::setHandler(
        static function ($var) use ($cloner, $dumper): void {
            $dumper->dump($cloner->cloneVar($var)); // dump
        }
    );
}

function getHost(): string
{
    $srv = getenv('VAR_DUMPER_SERVER');

    return $srv === false
        ? 'tcp://127.0.0.1:9912'
        : sprintf('tcp://%s', $srv);
}

function getDumper(): AbstractDumper
{
    return in_array(PHP_SAPI, ['cli', 'phpdbg'], true)
        ? new CliDumper()
        : new HtmlDumper();
}
