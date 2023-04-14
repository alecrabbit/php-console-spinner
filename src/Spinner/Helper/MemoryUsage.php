<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Helper;

final class MemoryUsage
{
    protected const UNITS = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

    public static function report(?string $prefix = null, ?int $bytes = null): string
    {
        $prefix ??= 'Memory usage: ';
        return
            $prefix . self::format($bytes ?? memory_get_peak_usage(true));
    }

    private static function format(int $memoryUsage): string
    {
        $i = (int)floor(log($memoryUsage, 1024));
        return
            round($memoryUsage / (1024 ** $i), 2) . self::UNITS[$i];
    }
}
