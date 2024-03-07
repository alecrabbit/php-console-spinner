<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Helper\MemoryUsage;
use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReportPrinter;
use DateTimeImmutable;

final readonly class MemoryUsageReportPrinter implements IMemoryUsageReportPrinter
{
    public function print(): void
    {
        static $memoryUsage = new MemoryUsage();

        echo
            sprintf(
                '%s %s',
                (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
                $memoryUsage->report(),
            )
            . PHP_EOL;
    }
}
