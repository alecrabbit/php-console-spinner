<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use Throwable;

final class MeasurementFormatter implements IMeasurementFormatter
{
    private const FORMAT = '%01.2f%s';
    private string $format;

    public function __construct(
        string $format = null,
        protected string $shortFormat = self::FORMAT,
        string $formatPrototype = '%s [%s/%s]',
    ) {
        $this->format =
            $format
            ??
            sprintf(
                $formatPrototype,
                $this->shortFormat,
                $this->shortFormat,
                $this->shortFormat,
            );
    }


    public function format(IMeasurement $measurement): string
    {
        $units = $measurement->getUnit()->value;
        try {
            return
                sprintf(
                    $this->format,
                    $measurement->getAverage(),
                    $units,
                    $measurement->getMax(),
                    $units,
                    $measurement->getMin(),
                    $units,
                );
        } catch (Throwable $_) {
            return $this->extractAny($measurement);
        }
    }

    protected function extractAny(IMeasurement $measurement): string
    {
        $units = $measurement->getUnit()->value;

        try {
            if ($measurement->getCount() >= 2) {
                return
                    sprintf(
                        $this->format,
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
                    $this->shortFormat,
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
