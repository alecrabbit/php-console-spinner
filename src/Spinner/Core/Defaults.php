<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ADefaults;

final class Defaults extends ADefaults
{
    private static float|int $shutdownDelay = self::SHUTDOWN_DELAY;
    private static bool $synchronousMode = self::SYNCHRONOUS_MODE;
    private static bool $hideCursor = self::HIDE_CURSOR;

    public static function shutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public static function synchronousMode(): bool
    {
        return self::$synchronousMode;
    }

    public static function hideCursor(): bool
    {
        return self::$hideCursor;
    }
}
