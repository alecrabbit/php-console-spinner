<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurementKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use DateTimeImmutable;

final class ReportPrinter implements IReportPrinter
{
    public function __construct(
        protected IReport $report,
        protected IOutput $output,
        protected IDatetimeFormatter $datetimeFormatter,
        protected IMeasurementFormatter $measurementFormatter,
        protected IMeasurementKeyFormatter $measurementKeyFormatter,
    ) {
    }

    public function print(): void
    {
        $prefix = $this->report->getPrefix();

        $output = $this->initialOutput($prefix);

        /** @var string $key */
        /** @var IMeasurement $measurement */
        foreach ($this->report->getMeasurements() as $key => $measurement) {
            $output .=
                sprintf(
                    '%s[%s]: %s' . PHP_EOL,
                    $this->measurementKeyFormatter->format($key, $prefix),
                    $measurement->getCount(),
                    $this->measurementFormatter->format($measurement),
                );
        }

        $this->output->write($output);
    }

    private function initialOutput(string $prefix): string
    {
        return
            <<<HEADER
            Benchmark Report
            {$this->report->getHeader()}
            Date: {$this->datetimeFormatter->format(new DateTimeImmutable())}
            
            {$prefix}
            
            HEADER;
    }
}
