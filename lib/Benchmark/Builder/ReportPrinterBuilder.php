<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\ReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use LogicException;

final class ReportPrinterBuilder implements IReportPrinterBuilder
{
    protected IOutput $output;
    protected IDatetimeFormatter $datetimeFormatter;
    protected IResultFormatter $measurementFormatter;
    protected IKeyFormatter $measurementKeyFormatter;

    public function build(): IReportPrinter
    {
        $this->validate();

        return
            new ReportPrinter(
                output: $this->output,
                datetimeFormatter: $this->datetimeFormatter,
                resultFormatter: $this->measurementFormatter,
                keyFormatter: $this->measurementKeyFormatter,
            );
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->output) => throw new LogicException('Output is not set.'),
            !isset($this->datetimeFormatter) => throw new LogicException('Datetime formatter is not set.'),
            !isset($this->measurementFormatter) => throw new LogicException('Measurement formatter is not set.'),
            !isset($this->measurementKeyFormatter) => throw new LogicException(
                'Measurement key formatter is not set.'
            ),
            default => null,
        };
    }

    public function withOutput(IOutput $output): IReportPrinterBuilder
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withDatetimeFormatter(IDatetimeFormatter $datetimeFormatter): IReportPrinterBuilder
    {
        $clone = clone $this;
        $clone->datetimeFormatter = $datetimeFormatter;
        return $clone;
    }

    public function withMeasurementFormatter(IResultFormatter $measurementFormatter): IReportPrinterBuilder
    {
        $clone = clone $this;
        $clone->measurementFormatter = $measurementFormatter;
        return $clone;
    }

    public function withMeasurementKeyFormatter(
        IKeyFormatter $measurementKeyFormatter
    ): IReportPrinterBuilder {
        $clone = clone $this;
        $clone->measurementKeyFormatter = $measurementKeyFormatter;
        return $clone;
    }
}
