<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IOutput;

use const AlecRabbit\Cli\CSI;

final class Driver implements IDriver
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

    public function moveBackSequence(int $i = 1): string
    {
        return CSI . "{$i}D";
    }

    public function eraseSequence(int $i = 1): string
    {
        return CSI . "{$i}X";
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

    public function getOutput(): IOutput
    {
        return $this->output;
    }
}
