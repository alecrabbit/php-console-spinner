<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Core\ColorMode;
use Symfony\Component\Console\Output\AnsiColorMode;
use Symfony\Component\Console\Terminal;

final class TerminalProbe
{
    final protected const TERMINAL_DEFAULT_WIDTH = 100;
    final protected const TERMINAL_DEFAULT_COLOR_SUPPORT = ColorMode::ANSI8;

    public static function getColorMode(): ColorMode
    {
        if (\class_exists(Terminal::class)) {
            return
                match (Terminal::getColorMode()) {
                    AnsiColorMode::Ansi24 => ColorMode::ANSI24,
                    AnsiColorMode::Ansi8 => ColorMode::ANSI8,
                    AnsiColorMode::Ansi4 => ColorMode::ANSI4,
                    default => self::TERMINAL_DEFAULT_COLOR_SUPPORT, // future-proof
                };
        }

        return self::TERMINAL_DEFAULT_COLOR_SUPPORT;
    }

    public static function getWidth(): int
    {
        if (\class_exists(Terminal::class)) {
            return (new Terminal())->getWidth();
        }
        return self::TERMINAL_DEFAULT_WIDTH;
    }
}