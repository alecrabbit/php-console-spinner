<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Measurement;
use Throwable;

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

    protected function formatMeasurement(IMeasurement $measurement): string
    {
        try {
            return
                sprintf(
                    '%01.2f%s',
                    $measurement->getAverage(),
                    $this->stopwatch->getUnit()->value,
                );
        } catch (Throwable $_) {
            return
                '--';
        }
    }
}
