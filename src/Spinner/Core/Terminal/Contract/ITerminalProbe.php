<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\I\ColorMode;
use AlecRabbit\Spinner\I\IProbe;

interface ITerminalProbe extends IProbe
{
    public final const TERMINAL_DEFAULT_HIDE_CURSOR = true;
    public final const TERMINAL_DEFAULT_WIDTH = 100;
    public final const TERMINAL_DEFAULT_COLOR_SUPPORT = ColorMode::ANSI8;

    public static function getWidth(): int;

    public static function getColorMode(): ColorMode;

    public static function isHideCursor(): bool;
}