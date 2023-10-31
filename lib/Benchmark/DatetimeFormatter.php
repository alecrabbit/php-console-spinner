<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use DateTimeInterface;

final class DatetimeFormatter implements IDatetimeFormatter
{
    private const DEFAULT_FORMAT = DATE_RFC3339_EXTENDED;

    public function __construct(
        private string $format = self::DEFAULT_FORMAT
    ) {
    }

    public function format(DateTimeInterface $datetime): string
    {
        return $datetime->format($this->format);
    }
}
