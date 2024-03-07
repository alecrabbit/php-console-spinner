<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\IMemoryReportFormatter;
use RuntimeException;

class MemoryReportFormatter implements IMemoryReportFormatter
{

    public function format(): string
    {
        // TODO: Implement format() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
