<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminal;
use Symfony\Component\Console\Output\AnsiColorMode;
use Symfony\Component\Console\Terminal;

use function class_exists;

final class NativeTerminalProbe extends ATerminalProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getWidth(): int
    {
        return ITerminal::TERMINAL_DEFAULT_WIDTH;
    }

    public static function getColorMode(): ColorMode
    {
        return
            ITerminal::TERMINAL_DEFAULT_COLOR_SUPPORT;
    }
}