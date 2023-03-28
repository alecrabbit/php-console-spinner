<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\IProbe;
use AlecRabbit\Spinner\Contract\OptionStyleMode;

interface ITerminalProbe extends IProbe
{
    final public const TERMINAL_DEFAULT_CURSOR_MODE = OptionCursor::DISABLED;
    final public const TERMINAL_DEFAULT_WIDTH = 100;
    final public const TERMINAL_DEFAULT_COLOR_SUPPORT = OptionStyleMode::ANSI8;

    public static function getWidth(): int;

    public static function getColorMode(): OptionStyleMode;

    public static function getCursorMode(): OptionCursor;
}
