<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportPrinterFactory;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;

final class ReportPrinterFactory implements IReportPrinterFactory
{
    public function __construct(
        protected IReportPrinterBuilder $builder,
        protected IOutput $output,
        protected IDatetimeFormatter $datetimeFormatter,
        protected IMeasurementFormatter $measurementFormatter,
        protected IKeyFormatter $measurementKeyFormatter,
    ) {
    }

    public function create(): IReportPrinter
    {
        return
            $this->builder
                ->withOutput($this->output)
                ->withDatetimeFormatter($this->datetimeFormatter)
                ->withMeasurementFormatter($this->measurementFormatter)
                ->withMeasurementKeyFormatter($this->measurementKeyFormatter)
                ->build()
        ;
    }
}
