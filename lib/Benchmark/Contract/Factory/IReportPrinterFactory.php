<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IReportPrinter;

interface IReportPrinterFactory
{
    public function create(): IReportPrinter;
}
