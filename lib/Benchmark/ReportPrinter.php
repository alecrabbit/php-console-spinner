<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use DateTimeImmutable;

final class ReportPrinter implements IReportPrinter
{
    public function __construct(
        protected IOutput $output,
        protected IReportFormatter $reportFormatter,
    ) {
    }

    public function print(IReport $report): void
    {
        $this->output->write($this->reportFormatter->format($report));
    }
}
