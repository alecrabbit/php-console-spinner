<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportPrinterFactory;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;

final class ReportPrinterFactory implements IReportPrinterFactory
{
    public function __construct(
        protected IReportPrinterBuilder $builder,
        protected IOutput $output,
        protected IReportFormatter $reportFormatter,
    ) {
    }

    public function create(): IReportPrinter
    {
        return $this->builder
            ->withOutput($this->output)
            ->withReportFormatter($this->reportFormatter)
            ->build()
        ;
    }
}
