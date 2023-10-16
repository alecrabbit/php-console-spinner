<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper;

use AlecRabbit\Tests\Helper\Contract\IStopwatch;
use Throwable;

use function sprintf;
use function trim;
use function ucfirst;

readonly class StopwatchReporter implements Contract\IReporter
{
    public function __construct(
        private IStopwatch $stopwatch,
    ) {
    }

    public function report(): void
    {
        echo PHP_EOL . 'Measurements report:' . PHP_EOL;

        /** @var string $key */
        /** @var Measurement $measurement */
        foreach ($this->stopwatch->getMeasurements() as $key => $measurement) {
            echo sprintf(
                '%s: %s (Data points: %s)' . PHP_EOL,
                ucfirst(trim($key, ':'),),
                $this->extractValue($measurement),
                $measurement->getActualCount(),
            );
        }

        echo PHP_EOL;
    }

    protected function extractValue($measurement): string
    {
        try {
            return
                sprintf(
                    '%01.2fμs',
                    $measurement->getAverage(),
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
