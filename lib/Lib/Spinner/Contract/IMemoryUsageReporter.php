<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

interface IMemoryUsageReporter
{
    public function getReportInterval(): float;

    public function report(): void;
}
