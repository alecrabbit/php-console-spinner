<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\IMemoryReportFormatter;
use AlecRabbit\Lib\Spinner\Contract\IMemoryReportPrinter;

final class MemoryReportPrinter implements IMemoryReportPrinter
{
    public function __construct(
        private readonly IMemoryReportFormatter $formatter,
    ) {
    }

    public function getReportInterval(): float
    {
        return 60.0;
    }

    public function print(): void
    {
        echo $this->formatter->format(memory_get_usage(true)) . PHP_EOL;
    }
}
