<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use AlecRabbit\Benchmark\Builder\ReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\Factory\IReportPrinterFactory;
use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\DatetimeFormatter;
use AlecRabbit\Benchmark\Factory\BenchmarkFactory;
use AlecRabbit\Benchmark\Factory\BenchmarkResultsFactory;
use AlecRabbit\Benchmark\Factory\MeasurementFactory;
use AlecRabbit\Benchmark\Factory\ReportPrinterFactory;
use AlecRabbit\Benchmark\Factory\ResultMaker;
use AlecRabbit\Benchmark\Factory\StopwatchFactory;
use AlecRabbit\Benchmark\KeyFormatter;
use AlecRabbit\Benchmark\ReportFormatter;
use AlecRabbit\Benchmark\Stopwatch\Builder\StopwatchBuilder;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Benchmark\Stopwatch\ResultFormatter;
use AlecRabbit\Lib\Spinner\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Lib\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Lib\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Lib\Spinner\Factory\BenchmarkingDriverFactory;
use AlecRabbit\Lib\Spinner\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Core\Output\Output;
use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;

$registry = DefinitionRegistry::getInstance();

$registry->bind(new ServiceDefinition(ITimer::class, new MicrosecondTimer()));
$registry->bind(new ServiceDefinition(IDriverProviderFactory::class, BenchmarkingDriverProviderFactory::class));
$registry->bind(new ServiceDefinition(IResultMaker::class, ResultMaker::class));
$registry->bind(new ServiceDefinition(IBenchmarkResultsFactory::class, BenchmarkResultsFactory::class));
$registry->bind(new ServiceDefinition(IBenchmarkingDriverFactory::class, BenchmarkingDriverFactory::class));
$registry->bind(new ServiceDefinition(IBenchmarkingDriverBuilder::class, BenchmarkingDriverBuilder::class));
$registry->bind(new ServiceDefinition(IBenchmarkFactory::class, BenchmarkFactory::class));
$registry->bind(new ServiceDefinition(IMeasurementFactory::class, MeasurementFactory::class));
$registry->bind(new ServiceDefinition(IStopwatchBuilder::class, StopwatchBuilder::class));
$registry->bind(new ServiceDefinition(IStopwatchFactory::class, StopwatchFactory::class));
$registry->bind(new ServiceDefinition(IReportPrinterBuilder::class, ReportPrinterBuilder::class));
$registry->bind(new ServiceDefinition(IReportFormatter::class, ReportFormatter::class));
$registry->bind(new ServiceDefinition(IDatetimeFormatter::class, DatetimeFormatter::class));
$registry->bind(new ServiceDefinition(IResultFormatter::class, ResultFormatter::class));
$registry->bind(new ServiceDefinition(IKeyFormatter::class, KeyFormatter::class));

$registry->bind(
    new ServiceDefinition(

        IReportPrinter::class,
        static function (ContainerInterface $container): IReportPrinter {
            return $container->get(IReportPrinterFactory::class)->create();
        }
    ),
);

$registry->bind(
    new ServiceDefinition(
        IReportPrinterFactory::class,
        static function (ContainerInterface $container): IReportPrinterFactory {
            $stream =
                new class implements IWritableStream {
                    public function write(Traversable $data): void
                    {
                        foreach ($data as $el) {
                            echo $el;
                        }
                    }
                };

            $output =
                new Output(
                    $stream
                );

            return
                new ReportPrinterFactory(
                    $container->get(IReportPrinterBuilder::class),
                    $output,
                    $container->get(IReportFormatter::class),
                );
        }
    )
);

$container = (new ContainerFactory($registry))->create();

Facade::useContainer($container);

return $container;
