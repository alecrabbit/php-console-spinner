<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWriter;

use const AlecRabbit\Cli\TERM_256COLOR;

final class Driver implements IDriver
{
    public function __construct(
        private readonly IWriter $writer,
    ) {
    }

    public function hideCursor(): void
    {
        $this->writer->write(
            Sequencer::hideCursorSequence()
        );
    }

    public function showCursor(): void
    {
        $this->writer->write(
            Sequencer::showCursorSequence()
        );
    }

    public function writeFrame(IFrame $frame): void
    {
        $this->writer->write(
            $frame->sequence,
            Sequencer::moveBackSequence($frame->sequenceWidth),
        );
    }

    public function erase(?int $i = null): void
    {
        $this->writer->write(
            Sequencer::eraseSequence($i ?? Defaults::ERASE_WIDTH)
        );
    }

    public function getWriter(): IWriter
    {
        return $this->writer;
    }

    public function getTerminalColorSupport(): int
    {
        // FIXME (2022-06-10 17:37) [Alec Rabbit]: Implement color support level detection.
        return TERM_256COLOR;
    }

    public function write(string $message): void
    {
        $this->writer->write($message);
    }
}
