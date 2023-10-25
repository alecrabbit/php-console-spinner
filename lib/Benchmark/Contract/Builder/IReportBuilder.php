<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Builder;

use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IReport;

interface IReportBuilder
{
    public function build(): IReport;

    public function withTitle(string $title): IReportBuilder;

    public function withBenchmarkResults(IBenchmarkResults $results): IReportBuilder;
}
