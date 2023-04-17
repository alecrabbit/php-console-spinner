<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ATerminalProbe implements ITerminalProbe
{
    use NoInstanceTrait;

    abstract public static function isAvailable(): bool;

    abstract public static function getWidth(): int;

    abstract public static function getColorMode(): OptionStyleMode;

    public static function getCursorMode(): OptionCursor
    {
        return ITerminalProbe::TERMINAL_DEFAULT_CURSOR_MODE;
    }
}
