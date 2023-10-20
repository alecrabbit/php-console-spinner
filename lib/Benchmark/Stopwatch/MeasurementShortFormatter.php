<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use Throwable;

final class MeasurementShortFormatter implements IMeasurementFormatter
{
    public function format(IMeasurement $measurement): string
    {
        try {
            return
                sprintf(
                    '%01.2f%s',
                    $measurement->getAverage(),
                    'μs',
                );
        } catch (Throwable $_) {
            return
                '--';
        }
    }
}
