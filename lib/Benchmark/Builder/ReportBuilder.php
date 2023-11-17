<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Report;
use InvalidArgumentException;

final class ReportBuilder implements IReportBuilder
{
    private IBenchmarkResults $results;
    private string $title;
    private ?string $prefix = null;

    public function build(): IReport
    {
        $this->validate();

        return new Report(
            $this->results,
            $this->title,
            $this->prefix,
        );
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->results) => throw new InvalidArgumentException('BenchmarkResults is not set.'),
            !isset($this->title) => throw new InvalidArgumentException('Title is not set.'),
            default => null,
        };
    }

    public function withTitle(string $title): IReportBuilder
    {
        $clone = clone $this;
        $clone->title = $title;
        return $clone;
    }

    public function withBenchmarkResults(IBenchmarkResults $results): IReportBuilder
    {
        $clone = clone $this;
        $clone->results = $results;
        return $clone;
    }
}
