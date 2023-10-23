<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Report;

final class ReportBuilder implements IReportBuilder
{
    private \Traversable $measurements;
    private string $header;
    private string $prefix;

    public function build(): IReport
    {
        $this->validate();

        return
            new Report(
                $this->measurements,
                $this->header,
                $this->prefix,
            );
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->measurements) => throw new \LogicException('Measurements are not set.'),
            !isset($this->header) => throw new \LogicException('Header is not set.'),
            !isset($this->prefix) => throw new \LogicException('Prefix is not set.'),
            default => null,
        };
    }

    public function withMeasurements(\Traversable $measurements): IReportBuilder
    {
        $clone = clone $this;
        $clone->measurements = $measurements;
        return $clone;
    }

    public function withHeader(string $header): IReportBuilder
    {
        $clone = clone $this;
        $clone->header = $header;
        return $clone;
    }

    public function withPrefix(string $prefix): IReportBuilder
    {
        $clone = clone $this;
        $clone->prefix = $prefix;
        return $clone;
    }
}
