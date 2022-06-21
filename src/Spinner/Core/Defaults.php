<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ADefaults;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;

final class Defaults extends ADefaults
{
    private static float|int $shutdownDelay = self::SHUTDOWN_DELAY;
    private static bool $synchronousMode = self::SYNCHRONOUS_MODE;
    private static bool $hideCursor = self::HIDE_CURSOR;
    private static ?array $defaultStyle = null;

    public static function shutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public static function defaultStyle(): array
    {
        if (null === self::$defaultStyle) {
            self::$defaultStyle = StylePattern::rainbow();
        }
        return self::$defaultStyle;
    }

    public function setDefaultStyle(array $style): void
    {
        self::$defaultStyle = $style;
    }

    public static function synchronousMode(): bool
    {
        return self::$synchronousMode;
    }

    public static function hideCursor(): bool
    {
        return self::$hideCursor;
    }

    public static function setShutdownDelay(float|int $shutdownDelay): void
    {
        self::$shutdownDelay = $shutdownDelay;
    }

    public static function setSynchronousMode(bool $synchronousMode): void
    {
        self::$synchronousMode = $synchronousMode;
    }

    public static function setHideCursor(bool $hideCursor): void
    {
        self::$hideCursor = $hideCursor;
    }
}
