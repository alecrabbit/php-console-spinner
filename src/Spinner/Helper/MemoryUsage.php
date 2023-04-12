<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Helper;

final class MemoryUsage
{
    protected const UNITS = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

    public static function report(?int $memoryUsage = null, ?string $prefix = null): string
    {
        $prefix ??= 'Memory usage: ';
        return
            $prefix . self::format($memoryUsage ?? memory_get_peak_usage(true));
    }

    private static function format(int $memoryUsage): string
    {
        $i = floor(log($memoryUsage, 1024));
        return
            round($memoryUsage / (1024 ** $i), 2) . self::UNITS[$i];
    }
}
