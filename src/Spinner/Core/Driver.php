<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IWriter;

final class Driver implements IDriver
{
    public function __construct(
        private readonly IWriter $writer,
        private readonly ISequencer $sequencer,
        private readonly IRenderer $renderer,
    ) {
    }

    public function hideCursor(): void
    {
        $this->writer->write(
            $this->sequencer->hideCursorSequence()
        );
    }

    public function showCursor(): void
    {
        $this->writer->write(
            $this->sequencer->showCursorSequence()
        );
    }

    public function showFrame(IFrame $frame): void
    {
        $this->writer->write(
            $this->sequencer->frameSequence($frame->sequence),
            $this->sequencer->moveBackSequence($frame->sequenceWidth),
        );
    }

    public function eraseFrame(): void
    {
        $this->writer->write(
            $this->sequencer->eraseSequence()
        );
    }

    public function getWriter(): IWriter
    {
        return $this->writer;
    }

    public function getRenderer(): IRenderer
    {
        return $this->renderer;
    }
}
