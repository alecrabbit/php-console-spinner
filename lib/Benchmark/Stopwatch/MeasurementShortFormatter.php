<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Stopwatch\Contract\IMeasurement;
use AlecRabbit\Benchmark\Stopwatch\Contract\IMeasurementFormatter;
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
                    $measurement->getUnit()->value,
                );
        } catch (Throwable $_) {
            return
                '--';
        }
    }
}
