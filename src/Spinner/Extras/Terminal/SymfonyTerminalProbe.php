<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Terminal;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;
use Symfony\Component\Console\Output\AnsiColorMode;
use Symfony\Component\Console\Terminal;

use function class_exists;

/**
 * @codeCoverageIgnore
 */
final class SymfonyTerminalProbe extends ATerminalProbe
{
    public function isAvailable(): bool
    {
        return class_exists(Terminal::class);
    }

    public function getWidth(): int
    {
        return (new Terminal())->getWidth();
    }

    public function getOptionStyleMode(): OptionStyleMode
    {
        return match (Terminal::getColorMode()) {
            AnsiColorMode::Ansi24 => OptionStyleMode::ANSI24,
            AnsiColorMode::Ansi8 => OptionStyleMode::ANSI8,
            AnsiColorMode::Ansi4 => OptionStyleMode::ANSI4,
        };
    }

    public function getOutputStream()
    {
        return STDERR;
    }
}
