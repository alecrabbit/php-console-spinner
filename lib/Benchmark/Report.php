<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IReport;

final class Report implements IReport
{
    public function __construct(
        protected IBenchmarkResults $benchmarkResults,
        protected string $title,
        protected ?string $prefix = null,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrefix(): string
    {
        return $this->prefix ?? '';
    }

    /** @inheritDoc */
    public function getResults(): iterable
    {
        return $this->benchmarkResults->getResults();
    }
}
