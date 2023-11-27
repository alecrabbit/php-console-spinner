<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\ReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use InvalidArgumentException;

final class ReportPrinterBuilder implements IReportPrinterBuilder
{
    private IOutput $output;
    private IReportFormatter $reportFormatter;

    public function build(): IReportPrinter
    {
        $this->validate();

        return new ReportPrinter(
            output: $this->output,
            reportFormatter: $this->reportFormatter,
        );
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->output) => throw new InvalidArgumentException('Output is not set.'),
            !isset($this->reportFormatter) => throw new InvalidArgumentException('Report formatter is not set.'),
            default => null,
        };
    }

    public function withOutput(IOutput $output): IReportPrinterBuilder
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withReportFormatter(IReportFormatter $reportFormatter): IReportPrinterBuilder
    {
        $clone = clone $this;
        $clone->reportFormatter = $reportFormatter;
        return $clone;
    }
}
