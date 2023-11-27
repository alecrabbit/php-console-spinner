<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;

final class ResultShortFormatter implements IResultFormatter
{
    private const FORMAT = '%01.2f%s';

    public function __construct(
        protected string $format = self::FORMAT,
        protected string $units = 'μs',
    ) {
    }

    public function format(IResult $result): string
    {
        return sprintf(
            $this->format,
            $result->getAverage(),
            $this->units,
        );
    }
}
