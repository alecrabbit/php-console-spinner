<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper;

use AlecRabbit\Tests\Helper\Contract\IStopwatch;

class StopwatchReporter implements Contract\IStopwatchReporter
{
    public function report(IStopwatch $stopwatch): void
    {
        echo PHP_EOL . 'Measurements report:' . PHP_EOL;

        foreach ($stopwatch->getMeasurements() as $key => $measurement) {
            echo sprintf(
                '%s: %s (Data points: %s)' . PHP_EOL,
                $key,
                $this->extractValue($measurement),
                $measurement->getCount(),
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
        } catch (\Throwable $e) {
            return
                sprintf(
                    '%s (Required data points: %s)',
                    $e->getMessage(),
                    $measurement->getRequiredCount(),
                );
        }
    }
}
