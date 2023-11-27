<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use DateTimeImmutable;

final readonly class ReportFormatter implements IReportFormatter
{
    public function __construct(
        private IDatetimeFormatter $datetimeFormatter,
        private IResultFormatter $resultFormatter,
        private IKeyFormatter $keyFormatter,
    ) {
    }

    public function format(IReport $report): string
    {
        $prefix = $report->getPrefix();

        $output = $this->initialOutput($report);

        /** @var string $key */
        /** @var IMeasurement $result */
        foreach ($report->getResults() as $key => $result) {
            $output .=
                sprintf(
                    '%s[%s]: %s' . PHP_EOL,
                    $this->keyFormatter->format($key, $prefix),
                    $result->getCount(),
                    $this->resultFormatter->format($result),
                );
        }

        return $output;
    }

    private function initialOutput(IReport $report): string
    {
        return <<<HEADER
            Benchmark Report
            {$report->getTitle()}
            Date: {$this->datetimeFormatter->format(new DateTimeImmutable())}
            {$this->extractPrefix($report)}
            HEADER;
    }

    private function extractPrefix(IReport $report): string
    {
        $prefix = $report->getPrefix();
        return $prefix === '' ? '' : PHP_EOL . "Prefix: {$prefix}" . PHP_EOL;
    }
}
