<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Factory;

use AlecRabbit\Spinner\Helper\Benchmark\Contract;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IMeasurement;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;
use AlecRabbit\Spinner\Helper\Benchmark\Measurement;
use Throwable;

use function sprintf;

readonly class StopwatchShortReportFactory implements Contract\Factory\IReportFactory
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
                    $this->extractValue($measurement),
                );
        }

        return $output;
    }

    protected function extractValue(IMeasurement $measurement): string
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
