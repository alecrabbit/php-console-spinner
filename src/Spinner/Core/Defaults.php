<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ADefaults;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;

final class Defaults extends ADefaults
{
    private static float|int $shutdownDelay = self::SHUTDOWN_DELAY;
    private static float|int $maxIntervalMilliseconds = self::MILLISECONDS_MAX_INTERVAL;
    private static bool $synchronousMode = self::SYNCHRONOUS_MODE;
    private static bool $hideCursor = self::HIDE_CURSOR;
    private static ?array $defaultStyle = null;

    public static function shutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public static function getDefaultStyle(): array
    {
        if (null === self::$defaultStyle) {
            self::$defaultStyle = StylePattern::rainbow();
        }
        return self::$defaultStyle;
    }

    public static function setDefaultStyle(array $style): void
    {
        self::$defaultStyle = $style;
    }

    public static function getMaxIntervalMilliseconds(): int|float
    {
        return self::$maxIntervalMilliseconds;
    }

    public static function setMaxIntervalMilliseconds(float|int $maxIntervalMilliseconds): void
    {
        self::$maxIntervalMilliseconds = $maxIntervalMilliseconds;
    }

    public static function getSynchronousMode(): bool
    {
        return self::$synchronousMode;
    }

    public static function setSynchronousMode(bool $synchronousMode): void
    {
        self::$synchronousMode = $synchronousMode;
    }

    public static function getHideCursor(): bool
    {
        return self::$hideCursor;
    }

    public static function setHideCursor(bool $hideCursor): void
    {
        self::$hideCursor = $hideCursor;
    }

    public static function getShutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public static function setShutdownDelay(float|int $shutdownDelay): void
    {
        self::$shutdownDelay = $shutdownDelay;
    }
}
