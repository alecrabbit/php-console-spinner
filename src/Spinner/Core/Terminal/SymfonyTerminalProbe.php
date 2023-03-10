<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;
use Symfony\Component\Console\Output\AnsiColorMode;
use Symfony\Component\Console\Terminal;

use function class_exists;

final class SymfonyTerminalProbe extends ATerminalProbe
{
    public static function isSupported(): bool
    {
        return class_exists(Terminal::class);
    }

    public static function getWidth(): int
    {
        return (new Terminal())->getWidth();
    }

    public static function getColorMode(): ColorMode
    {
        return
            match (Terminal::getColorMode()) {
                AnsiColorMode::Ansi24 => ColorMode::ANSI24,
                AnsiColorMode::Ansi8 => ColorMode::ANSI8,
                AnsiColorMode::Ansi4 => ColorMode::ANSI4,
            };
    }
}