<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

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
        $output = PHP_EOL . 'Measurements report:' . PHP_EOL;

        /** @var string $key */
        /** @var Measurement $measurement */
        foreach ($this->stopwatch->getMeasurements() as $key => $measurement) {
            $output .= sprintf(
                '%s: %s (Data points: %s)' . PHP_EOL,
                ucfirst(trim($key, ':'),),
                $this->extractValue($measurement),
                $measurement->getActualCount(),
            );
        }

        return $output . PHP_EOL;
    }

    protected function extractValue($measurement): string
    {
        try {
            return
                sprintf(
                    '%01.2f%s',
                    $measurement->getAverage(),
                    $measurement->getUnits(),
                );
        } catch (Throwable $e) {
            return
                sprintf(
                    '%s (Required data points: %s)',
                    $e->getMessage(),
                    $measurement->getRequiredCount(),
                );
        }
    }
}
