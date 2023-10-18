<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

use AlecRabbit\Tests\Helper\Benchmark\Contract\IMeasurement;
use AlecRabbit\Tests\Helper\Benchmark\Contract\IStopwatch;
use Throwable;

use function sprintf;
use function trim;
use function ucfirst;

readonly class StopwatchReportFactory implements Contract\IReportFactory
{
    public function __construct(
        private IStopwatch $stopwatch,
    ) {
    }

    public function report(): string
    {
        $output = PHP_EOL
            . sprintf(
                '%s (%s: %s):',
                'Measurements report',
                'Required data points',
                $this->stopwatch->getRequiredMeasurements(),
            )
            . PHP_EOL;

        /** @var string $key */
        /** @var IMeasurement $measurement */
        foreach ($this->stopwatch->getMeasurements() as $key => $measurement) {
            $output .= sprintf(
                '%s: %s (Data points: %s)' . PHP_EOL,
                ucfirst(trim($key, ':'),),
                $this->extractValue($measurement),
                $measurement->getCount(),
            );
        }

        return $output . PHP_EOL;
    }

    protected function extractValue(IMeasurement $measurement): string
    {
        try {
            return
                sprintf(
                    '%01.2f%s [%01.2f/%01.2f]',
                    $measurement->getAverage(),
                    $this->stopwatch->getUnits(),
                    $measurement->getMax(),
                    $measurement->getMin(),
                );
        } catch (Throwable $e) {
            return
                sprintf(
                    '%s',
                    $e->getMessage(),
                );
        }
    }
}
