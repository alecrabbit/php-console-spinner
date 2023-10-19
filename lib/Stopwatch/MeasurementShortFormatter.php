<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch;

use AlecRabbit\Stopwatch\Contract\IMeasurement;
use AlecRabbit\Stopwatch\Contract\IMeasurementFormatter;

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
        } catch (\Throwable $_) {
            return
                '--';
        }
    }
}
