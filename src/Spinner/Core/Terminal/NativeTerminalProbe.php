<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;

final class NativeTerminalProbe extends ATerminalProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getWidth(): int
    {
        return self::TERMINAL_DEFAULT_WIDTH;
    }

    public static function getColorMode(): ColorMode
    {
        return self::TERMINAL_DEFAULT_COLOR_SUPPORT;
    }
}
