<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Contract\Cursor;
use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ATerminalProbe implements ITerminalProbe
{
    use NoInstanceTrait;

    abstract public static function isSupported(): bool;

    abstract public static function getWidth(): int;

    abstract public static function getColorMode(): StyleMode;

    public static function getCursorMode(): Cursor
    {
        return ITerminalProbe::TERMINAL_DEFAULT_CURSOR_MODE;
    }
}
