<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

use AlecRabbit\Tests\Helper\Benchmark\Contract\IMeasurement;
use AlecRabbit\Tests\Helper\Benchmark\Contract\IStopwatch;
use DateTimeImmutable;
use Throwable;

use function sprintf;

readonly class StopwatchShortReportFactory implements Contract\IReportFactory
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
