<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Report;

final class ReportBuilder implements IReportBuilder
{
    private IBenchmark $benchmark;
    private string $title;

    public function build(): IReport
    {
        $this->validate();

        return
            new Report(
                $this->benchmark,
                $this->title,
            );
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->benchmark) => throw new \LogicException('Benchmark is not set.'),
            !isset($this->title) => throw new \LogicException('Title is not set.'),
            default => null,
        };
    }

    public function withTitle(string $title): IReportBuilder
    {
        $clone = clone $this;
        $clone->title = $title;
        return $clone;
    }

    public function withBenchmark(IBenchmark $benchmark): IReportBuilder
    {
        $clone = clone $this;
        $clone->benchmark = $benchmark;
        return $clone;
    }
}
