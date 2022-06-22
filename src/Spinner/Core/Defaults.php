<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ADefaults;
use AlecRabbit\Spinner\Kernel\Contract\Base\CharPattern;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;

final class Defaults extends ADefaults
{
    private static float|int $shutdownDelay = self::SHUTDOWN_DELAY;
    private static float|int $maxIntervalMilliseconds = self::MILLISECONDS_MAX_INTERVAL;
    private static float|int $minIntervalMilliseconds = self::MILLISECONDS_MIN_INTERVAL;
    private static bool $synchronousMode = self::SYNCHRONOUS_MODE;
    private static bool $hideCursor = self::HIDE_CURSOR;
    private static ?array $defaultStylePattern = null;
    private static ?array $defaultCharPattern = null;

    public static function shutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public static function getMinIntervalMilliseconds(): float|int
    {
        return self::$minIntervalMilliseconds;
    }

    public static function setMinIntervalMilliseconds(float|int $minIntervalMilliseconds): void
    {
        self::$minIntervalMilliseconds = $minIntervalMilliseconds;
    }


    public static function getMaxIntervalMilliseconds(): float|int
    {
        return self::$maxIntervalMilliseconds;
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

    public static function getDefaultCharPattern(): array
    {
        if (null === self::$defaultCharPattern) {
            self::$defaultCharPattern = CharPattern::SNAKE_VARIANT_0;
        }
        return self::$defaultCharPattern;
    }

    public static function getDefaultStylePattern(): array
    {
        if (null === self::$defaultStylePattern) {
            self::$defaultStylePattern = StylePattern::rainbow();
        }
        return self::$defaultStylePattern;
    }

    public static function setDefaultStylePattern(array $style): void
    {
        self::$defaultStylePattern = $style;
    }
}
