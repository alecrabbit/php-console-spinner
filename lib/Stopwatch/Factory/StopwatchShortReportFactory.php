<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch\Factory;

use AlecRabbit\Stopwatch\Contract\Factory\IReportFactory;
use AlecRabbit\Stopwatch\Contract\IMeasurement;
use AlecRabbit\Stopwatch\Contract\IMeasurementFormatter;
use AlecRabbit\Stopwatch\Contract\IStopwatch;

use function sprintf;

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

        return \trim($output);
    }
}
