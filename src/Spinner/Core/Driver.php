<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;

use const AlecRabbit\Cli\CSI;

/**
 * @internal
 */
final class Driver
{
    private const HIDE_CURSOR_SEQ = CSI . "?25l";
    private const SHOW_CURSOR_SEQ = CSI . "?25h";

    public function __construct(
        private IOutput $output
    ) {
    }

    public function write(string ...$sequences): void
    {
        $this->output->write($sequences);
    }

    public function frameSequence(string $fg, string $char): string
    {
        return CSI . "38;5;{$fg}m{$char}\033[0m";
    }
    public function moveBackSequence(): string
    {
        return CSI . "1D";
    }

    public function eraseSequence(): string
    {
        return CSI . "1X";
    }
    
    public function hideCursor(): void
    {
        $this->write(self::HIDE_CURSOR_SEQ);
    }


    public function showCursor(): void
    {
        $this->write(self::SHOW_CURSOR_SEQ);
    }
}
