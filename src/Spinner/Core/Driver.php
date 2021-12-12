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
    private const SEQ_HIDE_CURSOR = CSI . '?25l';
    private const SEQ_SHOW_CURSOR = CSI . '?25h';

    public function __construct(
        private IOutput $output
    ) {
    }

    public function frameSequence(string $fg, string $char): string
    {
        return CSI . "38;5;{$fg}m{$char}\033[0m";
    }

    public function moveBackSequence(): string
    {
        return CSI . '1D';
    }

    public function eraseSequence(): string
    {
        return CSI . '1X';
    }

    public function hideCursor(): void
    {
        $this->write(self::SEQ_HIDE_CURSOR);
    }

    public function write(string ...$sequences): void
    {
        $this->output->write($sequences);
    }

    public function showCursor(): void
    {
        $this->write(self::SEQ_SHOW_CURSOR);
    }
}
