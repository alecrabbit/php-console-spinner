<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IMemoryReportPrinter
{
    public function getReportInterval(): float;

    public function print(): void;
}
