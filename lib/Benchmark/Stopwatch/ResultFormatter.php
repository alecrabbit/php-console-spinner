<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;

final class ResultFormatter implements IResultFormatter
{
    private const FORMAT = '%01.2f%s';
    private string $format;

    public function __construct(
        ?string $format = null,
        protected string $shortFormat = self::FORMAT,
        string $formatPrototype = '%s [%s/%s]',
        protected string $units = 'μs',
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

    public function format(IResult $result): string
    {
        return sprintf(
            $this->format,
            $result->getAverage(),
            $this->units,
            $result->getMax(),
            $this->units,
            $result->getMin(),
            $this->units,
        );
    }
}
