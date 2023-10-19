<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;

final class MeasurementFormatter implements IMeasurementFormatter
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
