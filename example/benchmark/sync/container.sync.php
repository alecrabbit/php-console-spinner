<?php

declare(strict_types=1);

require_once __DIR__ . '/../container.php';

use AlecRabbit\Benchmark\Builder\ReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\ITimer as IBenchmarkTimer;
use AlecRabbit\Benchmark\DatetimeFormatter;
use AlecRabbit\Benchmark\Factory\BenchmarkFactory;
use AlecRabbit\Benchmark\Factory\BenchmarkResultsFactory;
use AlecRabbit\Benchmark\Factory\MeasurementFactory;
use AlecRabbit\Benchmark\Factory\ResultMaker;
use AlecRabbit\Benchmark\Factory\StopwatchFactory;
use AlecRabbit\Benchmark\KeyFormatter;
use AlecRabbit\Benchmark\ReportFormatter;
use AlecRabbit\Benchmark\Spinner\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Benchmark\Spinner\Factory\BenchmarkingDriverFactory;
use AlecRabbit\Benchmark\Spinner\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Benchmark\Stopwatch\Builder\StopwatchBuilder;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Benchmark\Stopwatch\ResultFormatter;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Facade;

// Replace default container:
$registry = DefinitionRegistry::getInstance();

$registry->bind(IBenchmarkTimer::class, new MicrosecondTimer());
$registry->bind(IDriverProviderFactory::class, BenchmarkingDriverProviderFactory::class);
$registry->bind(IResultMaker::class, ResultMaker::class);
$registry->bind(IBenchmarkResultsFactory::class, BenchmarkResultsFactory::class);
$registry->bind(IBenchmarkingDriverFactory::class, BenchmarkingDriverFactory::class);
$registry->bind(IBenchmarkingDriverBuilder::class, BenchmarkingDriverBuilder::class);
$registry->bind(IBenchmarkFactory::class, BenchmarkFactory::class);
$registry->bind(IMeasurementFactory::class, MeasurementFactory::class);
$registry->bind(IStopwatchBuilder::class, StopwatchBuilder::class);
$registry->bind(IStopwatchFactory::class, StopwatchFactory::class);
$registry->bind(IReportPrinterBuilder::class, ReportPrinterBuilder::class);
$registry->bind(IReportFormatter::class, ReportFormatter::class);
$registry->bind(IDatetimeFormatter::class, DatetimeFormatter::class);
$registry->bind(IResultFormatter::class, ResultFormatter::class);
$registry->bind(IKeyFormatter::class, KeyFormatter::class);

$registry = DefinitionRegistry::getInstance();

$registry->bind(
    IResourceStream::class,
    new class implements IResourceStream {
        public function write(Traversable $data): void
        {
            // unwrap $data
            iterator_to_array($data);
        }
    }
);
$registry->bind(
    ITimer::class,
    new class implements ITimer {
        public function getDelta(): float
        {
            // simulate unequal time intervals
            return (float)random_int(1000, 500000);
        }
    }
);

$container = (new ContainerFactory($registry))->create();

Facade::useContainer($container);

return $container;
