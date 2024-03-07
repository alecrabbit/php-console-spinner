<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

interface IMemoryUsageReportPrinter
{
    public function print(): void;
}
