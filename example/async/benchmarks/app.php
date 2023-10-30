<?php

declare(strict_types=1);

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
use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Benchmark\Factory\ReportPrinterFactory;
use AlecRabbit\Benchmark\Factory\ResultMaker;
use AlecRabbit\Benchmark\Factory\StopwatchFactory;
use AlecRabbit\Benchmark\KeyFormatter;
use AlecRabbit\Benchmark\ReportFormatter;
use AlecRabbit\Benchmark\Spinner\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Spinner\Factory\BenchmarkingDriverFactory;
use AlecRabbit\Benchmark\Spinner\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Benchmark\Stopwatch\Builder\StopwatchBuilder;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Benchmark\Stopwatch\ResultFormatter;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;
use AlecRabbit\Spinner\Probes;
use Psr\Container\ContainerInterface;

// in seconds
const RUNTIME = 600;
const MEMORY_REPORT_INTERVAL = 60;

require_once __DIR__ . '/../../bootstrap.php';

// Pick ONE of the following event loops:
Probes::unregister(\AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe::class);
//Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe::class);

// Replace default container:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(ITimer::class, new MicrosecondTimer());
    $registry->bind(IDriverProviderFactory::class, BenchmarkingDriverProviderFactory::class);
    $registry->bind(IResultMaker::class, ResultMaker::class);
    $registry->bind(IBenchmarkResultsFactory::class, BenchmarkResultsFactory::class);
    $registry->bind(IBenchmarkingDriverFactory::class, BenchmarkingDriverFactory::class);
    $registry->bind(IBenchmarkingDriverBuilder::class, BenchmarkingDriverBuilder::class);
    $registry->bind(IBenchmarkFactory::class, BenchmarkFactory::class);
    $registry->bind(IMeasurementFactory::class, MeasurementFactory::class);
    $registry->bind(IStopwatchBuilder::class, StopwatchBuilder::class);
    $registry->bind(IStopwatchFactory::class, StopwatchFactory::class);
    $registry->bind(IReportPrinterFactory::class, ReportPrinterFactory::class);
    $registry->bind(IReportPrinterBuilder::class, ReportPrinterBuilder::class);
    $registry->bind(IReportFormatter::class, ReportFormatter::class);
    $registry->bind(IDatetimeFormatter::class, DatetimeFormatter::class);
    $registry->bind(IResultFormatter::class, ResultFormatter::class);
    $registry->bind(IKeyFormatter::class, KeyFormatter::class);
    $registry->bind(IReportPrinter::class, static function (ContainerInterface $container): IReportPrinter {
        return $container->get(IReportPrinterFactory::class)->create();
    });
    $registry->bind(
        IOutput::class,
        new class implements IOutput {
            public function write(string|iterable $messages, bool $newline = false, int $options = 0): void
            {
                if (!is_iterable($messages)) {
                    $messages = [$messages];
                }
                foreach ($messages as $message) {
                    if ($newline) {
                        $message .= PHP_EOL;
                    }
                    echo $message;
                }
            }

            public function writeln(iterable|string $messages, int $options = 0): void
            {
                $this->write($messages, true, $options);
            }
        }
    );

    $container = (new ContainerFactory($registry))->create();

    Facade::useContainer($container);
}

$driver = Facade::getDriver();

if (!$driver instanceof IBenchmarkingDriver) {
    throw new \LogicException(
        sprintf(
            'Driver must implement "%s".',
            IBenchmarkingDriver::class
        )
    );
}

// Create echo function
$echo =
    $driver->wrap(
        static function (?string $message = null): void {
            echo $message . PHP_EOL;
        }
    );


/** @var IBenchmarkResultsFactory $benchmarkResultsFactory */
$benchmarkResultsFactory = $container->get(IBenchmarkResultsFactory::class);

$benchmarkResults =
    $benchmarkResultsFactory
        ->create(
            $driver
                ->getBenchmark()
                ->getMeasurements()
        )
;


// Create report function:
$reportPrinter = $container->get(IReportPrinter::class);

$reportObject =
    (new ReportFactory(benchmarkResults: $benchmarkResults, title: 'Benchmarking'))
        ->create()
;

$fullReport =
    static function () use ($reportPrinter, $reportObject): void {
        $reportPrinter->print($reportObject);
    };

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

// Stop loop after RUNTIME seconds
$loop
    ->delay(
        RUNTIME - 0.1,
        static function () use ($driver, $loop, $fullReport): void {
            $loop->stop();
            $driver->finalize();
            $fullReport();
        }
    )
;

// Execute memory report function every MEMORY_REPORT_INTERVAL seconds
$loop
    ->repeat(
        MEMORY_REPORT_INTERVAL,
        $memoryReport,
    )
;

$spinner = Facade::createSpinner();

// Remove spinner before loop stops
$loop
    ->delay(
        RUNTIME - 0.2,
        static function () use ($driver, $spinner): void {
            $driver->remove($spinner);
        }
    )
;

// Begin benchmarking
$echo(sprintf('Runtime: %ss', RUNTIME));
$echo();
$echo(sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial memory report
