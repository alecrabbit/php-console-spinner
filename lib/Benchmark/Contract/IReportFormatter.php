<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IReportFormatter
{
    public function format(IReport $report): string;
}
