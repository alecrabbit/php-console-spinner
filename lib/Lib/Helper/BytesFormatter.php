<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Helper;

use AlecRabbit\Lib\Helper\Contract\IBytesFormatter;

final class BytesFormatter implements IBytesFormatter
{
    private const UNITS = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB']; // 'EB' is max for int on 64-bit systems

    public function format(int $bytes): string
    {
        $i = (int)floor(log($bytes, 1024));
        return round($bytes / (1024 ** $i), 2) . self::getUnits($i);
    }

    private static function getUnits(int $i): string
    {
        return self::UNITS[$i];
    }
}
