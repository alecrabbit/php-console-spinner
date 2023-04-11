<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Extras\Terminal;

use AlecRabbit\Spinner\Contract\OptionStyleMode;
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

    public static function getColorMode(): OptionStyleMode
    {
        return
            match (Terminal::getColorMode()) {
                AnsiColorMode::Ansi24 => OptionStyleMode::ANSI24,
                AnsiColorMode::Ansi8 => OptionStyleMode::ANSI8,
                AnsiColorMode::Ansi4 => OptionStyleMode::ANSI4,
            };
    }
}
