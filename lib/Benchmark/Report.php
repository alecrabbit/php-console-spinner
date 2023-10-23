<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IReport;

final class Report implements IReport
{
    public function __construct(
        protected \Traversable $measurements,
        protected string $header,
        protected string $prefix,
    ) {
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /** @inheritDoc */
    public function getMeasurements(): iterable
    {
        return $this->measurements;
    }
}
