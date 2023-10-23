<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Builder;

use AlecRabbit\Benchmark\Contract\IReport;

interface IReportBuilder
{
    public function build(): IReport;

    public function withMeasurements(\Traversable $measurements): IReportBuilder;

    public function withHeader(string $header): IReportBuilder;

    public function withPrefix(string $prefix): IReportBuilder;
}
