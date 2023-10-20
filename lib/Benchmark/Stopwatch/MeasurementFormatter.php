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
        protected $units = 'μs',
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
        try {
            return
                sprintf(
                    $this->format,
                    $measurement->getAverage(),
                    $this->units,
                    $measurement->getMax(),
                    $this->units,
                    $measurement->getMin(),
                    $this->units,
                );
        } catch (Throwable $_) {
            return $this->extractAny($measurement);
        }
    }

    protected function extractAny(IMeasurement $measurement): string
    {
        try {
            if ($measurement->getCount() >= 2) {
                return
                    sprintf(
                        $this->format,
                        $measurement->getAny(),
                        $this->units,
                        $measurement->getMax(),
                        $this->units,
                        $measurement->getMin(),
                        $this->units,
                    );
            }
            return
                sprintf(
                    $this->shortFormat,
                    $measurement->getAny(),
                    $this->units,
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
