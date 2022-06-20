<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Kernel\Contract\IDriver;
use AlecRabbit\Spinner\Kernel\Contract\IWriter;

use const AlecRabbit\Cli\TERM_256COLOR;

final class Driver implements IDriver
{
    public function __construct(
        private readonly IWriter $writer,
        private readonly bool $hideCursor,
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

    public function writeFrame(ICharFrame $frame): void
    {
        $this->writer->write(
            $frame->getChar(),
            Sequencer::moveBackSequence($frame->getWidth()),
        );
    }

    public function erase(?int $i = null): void
    {
        $this->writer->write(
            Sequencer::eraseSequence($i ?? Defaults::ERASE_WIDTH)
        );
    }

    public function getTerminalColorSupport(): int
    {
        // FIXME (2022-06-10 17:37) [Alec Rabbit]: Implement color support level detection.
        return TERM_256COLOR;
    }

    public function render($whatever): void
    {
        dump($whatever);
    }
}
