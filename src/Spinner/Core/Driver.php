<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\IWriter;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;

use const AlecRabbit\Cli\TERM_256COLOR;

final class Driver implements IDriver
{
    public function __construct(
        private readonly bool $hideCursor,
        private readonly IWriter $writer,
        private readonly IRenderer $renderer,
    ) {
    }

    public function hideCursor(): void
    {
        if ($this->hideCursor) {
            $this->writer->write(
                Sequencer::hideCursorSequence()
            );
        }
    }

    public function message(string $message): void
    {
        $this->writer->write($message);
    }

    public function showCursor(): void
    {
        if ($this->hideCursor) {
            $this->writer->write(
                Sequencer::showCursorSequence()
            );
        }
    }

    public function erase(int $i): void
    {
        $this->writer->write(
            Sequencer::eraseSequence($i)
        );
    }

    public function getTerminalColorSupport(): int
    {
        // FIXME (2022-06-10 17:37) [Alec Rabbit]: Implement color support level detection.
        return TERM_256COLOR;
    }

    public function display(iterable $sequence): int
    {
        return $this->renderer->display($sequence);
    }
}
