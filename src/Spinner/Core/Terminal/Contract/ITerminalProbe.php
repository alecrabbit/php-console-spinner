<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Contract\Cursor;
use AlecRabbit\Spinner\Contract\IProbe;

interface ITerminalProbe extends IProbe
{
    final public const TERMINAL_DEFAULT_CURSOR_MODE = Cursor::DISABLED;
    final public const TERMINAL_DEFAULT_WIDTH = 100;
    final public const TERMINAL_DEFAULT_COLOR_SUPPORT = StyleMode::ANSI8;

    public static function getWidth(): int;

    public static function getColorMode(): StyleMode;

    public static function getCursorMode(): Cursor;
}
