<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Builder;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;

interface IReportPrinterBuilder
{
    public function build(): IReportPrinter;

    public function withOutput(IOutput $output): IReportPrinterBuilder;

    public function withDatetimeFormatter(IDatetimeFormatter $datetimeFormatter): IReportPrinterBuilder;

    public function withMeasurementFormatter(IResultFormatter $measurementFormatter): IReportPrinterBuilder;

    public function withMeasurementKeyFormatter(
        IKeyFormatter $measurementKeyFormatter
    ): IReportPrinterBuilder;
}
