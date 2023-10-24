<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Factory;

use AlecRabbit\Benchmark\Contract\Factory\ILegacyReportFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\IStopwatch;

use function sprintf;
use function trim;

readonly class StopwatchShortLegacyReportFactory implements ILegacyReportFactory
{
    public function __construct(
        private IStopwatch $stopwatch,
        private IResultFormatter $measurementFormatter,
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
