<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Factory;

use AlecRabbit\Benchmark\Stopwatch\Contract\Factory\IReportFactory;
use AlecRabbit\Benchmark\Stopwatch\Contract\IMeasurement;
use AlecRabbit\Benchmark\Stopwatch\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Stopwatch\Contract\IStopwatch;

use function sprintf;
use function trim;

readonly class StopwatchShortReportFactory implements IReportFactory
{
    public function __construct(
        private IStopwatch $stopwatch,
        private IMeasurementFormatter $measurementFormatter,
        private string $title = 'Timings',
    ) {
    }

    public function report(): string
    {
        $output =
            sprintf(
                '%s: ',
                $this->title,
            );

        /** @var string $key */
        /** @var IMeasurement $measurement */
        foreach ($this->stopwatch->getMeasurements() as $key => $measurement) {
            $output .=
                sprintf(
                    '%s ',
                    $this->measurementFormatter->format($measurement),
                );
        }

        return trim($output);
    }
}
