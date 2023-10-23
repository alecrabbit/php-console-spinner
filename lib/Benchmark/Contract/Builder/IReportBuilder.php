<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Builder;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IReport;

interface IReportBuilder
{
    public function build(): IReport;

    public function withBenchmark(IBenchmark $benchmark): IReportBuilder;

    public function withTitle(string $title): IReportBuilder;
}
