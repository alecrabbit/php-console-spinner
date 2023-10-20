<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IStopwatch;

use function sprintf;
use function trim;
use function ucfirst;

readonly class StopwatchReportFactory implements IReportFactory
{
    public function __construct(
        private IStopwatch $stopwatch,
        private IMeasurementFormatter $measurementFormatter,
        private string $title = 'Measurements report',
    ) {
    }

    public function report(): string
    {
        $output = PHP_EOL
            . sprintf(
                '%s (%s: %s):',
                $this->title,
                'Required data points',
                $this->stopwatch->getRequiredMeasurements(),
            )
            . PHP_EOL;

        /** @var string $key */
        /** @var IMeasurement $measurement */
        foreach ($this->stopwatch->getMeasurements() as $key => $measurement) {
            $output .=
                sprintf(
                    '%s: %s (Data points: %s)' . PHP_EOL,
                    $this->formatKey($key),
                    $this->measurementFormatter->format($measurement),
                    $measurement->getCount(),
                );
        }

        return $output;
    }

    protected function formatKey(string $key): string
    {
        return ucfirst(trim($key, ':'));
    }
}
