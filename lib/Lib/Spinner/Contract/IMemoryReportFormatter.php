<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

interface IMemoryReportFormatter
{
    public function format(): string;
}
