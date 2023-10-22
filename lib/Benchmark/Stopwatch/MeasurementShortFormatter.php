<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use Throwable;

final class MeasurementShortFormatter implements IMeasurementFormatter
{
    private const FORMAT = '%01.2f%s';

    public function __construct(
        protected string $format = self::FORMAT,
        protected string $units = 'μs',
    ) {
    }

    public function format(IMeasurement $measurement): string
    {
        try {
            return
                sprintf(
                    $this->format,
                    $measurement->getAverage(),
                    $this->units,
                );
        } catch (Throwable $_) {
            return
                '--';
        }
    }
}
