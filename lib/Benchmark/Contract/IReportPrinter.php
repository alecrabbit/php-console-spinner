<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IReportPrinter
{
    public function print(IReport $report): void;
}
