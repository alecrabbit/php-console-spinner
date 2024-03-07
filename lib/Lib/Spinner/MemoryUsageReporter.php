<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReporter;
use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReportPrinter;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;

final readonly class MemoryUsageReporter implements IMemoryUsageReporter
{
    public function __construct(
        private IMemoryUsageReportPrinter $printer,
    ) {
    }

    public function getReportInterval(): float
    {
        return 2.0;
    }

    public function report(): void
    {
        $this->printer->print();
    }
}
