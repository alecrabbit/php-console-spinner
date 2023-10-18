<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Factory;

use AlecRabbit\Spinner\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Spinner\Benchmark\Contract\IMeasurement;
use AlecRabbit\Spinner\Benchmark\Contract\IStopwatch;
use AlecRabbit\Spinner\Benchmark\Measurement;
use Throwable;

use function sprintf;

readonly class StopwatchShortReportFactory implements IReportFactory
{
    public function __construct(
        private IStopwatch $stopwatch,
    ) {
    }

    public function report(): string
    {
        $output =
            sprintf(
                '%s: ',
                'Timings',
            );

        /** @var string $key */
        /** @var Measurement $measurement */
        foreach ($this->stopwatch->getMeasurements() as $key => $measurement) {
            $output .=
                sprintf(
                    '%s ',
                    $this->formatMeasurement($measurement),
                );
        }

        return $output;
    }

    protected function formatMeasurement(IMeasurement $measurement): string
    {
        try {
            return
                sprintf(
                    '%01.2f%s',
                    $measurement->getAverage(),
                    $this->stopwatch->getUnits(),
                );
        } catch (Throwable $_) {
            return
                '--';
        }
    }
}
