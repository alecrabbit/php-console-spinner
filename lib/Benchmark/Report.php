<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IReport;

final class Report implements IReport
{
    public function __construct(
        protected IBenchmark $benchmark ,
        protected string $header,
    ) {
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getPrefix(): string
    {
        return $this->benchmark->getPrefix();
    }

    /** @inheritDoc */
    public function getMeasurements(): iterable
    {
        return $this->benchmark->getMeasurements();
    }
}
