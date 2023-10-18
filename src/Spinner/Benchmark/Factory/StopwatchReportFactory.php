<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Factory;

use AlecRabbit\Spinner\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Spinner\Benchmark\Contract\IMeasurement;
use AlecRabbit\Spinner\Benchmark\Contract\IStopwatch;
use Throwable;

use function sprintf;
use function trim;
use function ucfirst;

readonly class StopwatchReportFactory implements IReportFactory
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
                $this->formatKey($key),
                $this->formatMeasurement($measurement),
                $measurement->getCount(),
            );
        }

        return $output . PHP_EOL;
    }

    protected function formatMeasurement(IMeasurement $measurement): string
    {
        $units = $this->stopwatch->getUnits();

        try {
            return
                sprintf(
                    '%01.2f%s [%01.2f%s/%01.2f%s]',
                    $measurement->getAverage(),
                    $units,
                    $measurement->getMax(),
                    $units,
                    $measurement->getMin(),
                    $units,
                );
        } catch (Throwable $e) {
            try {
                if ($measurement->getCount() >= 2) {
                    return
                        sprintf(
                            '%01.2f%s [%01.2f%s/%01.2f%s]',
                            $measurement->getAny(),
                            $units,
                            $measurement->getMax(),
                            $units,
                            $measurement->getMin(),
                            $units,
                        );
                }
                return
                    sprintf(
                        '%01.2f%s',
                        $measurement->getAny(),
                        $units,
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

    protected function formatKey(string $key): string
    {
        return ucfirst(trim($key, ':'),);
    }
}
