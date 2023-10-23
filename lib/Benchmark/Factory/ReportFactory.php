<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Builder\ReportBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IReport;

final class ReportFactory implements IReportFactory
{
    public function __construct(
        protected IBenchmark $benchmark,
        protected string $title,
        protected IReportBuilder $reportBuilder = new ReportBuilder(),
    ) {
    }

    public function create(): IReport
    {
        return
            $this->reportBuilder
                ->withBenchmark($this->benchmark)
                ->withTitle($this->title)
                ->build()
        ;
    }
}
