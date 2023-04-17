<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;

final class NativeTerminalProbe extends ATerminalProbe
{
    public static function isAvailable(): bool
    {
        return true;
    }

    public static function getWidth(): int
    {
        return self::TERMINAL_DEFAULT_WIDTH;
    }

    public static function getColorMode(): OptionStyleMode
    {
        return self::TERMINAL_DEFAULT_COLOR_SUPPORT;
    }
}
