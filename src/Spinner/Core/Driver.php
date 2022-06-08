<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Contract\IWriter;

final class Driver implements IDriver
{
    public function __construct(
        private readonly IWriter $writer,
        private readonly IRenderer $renderer,
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

    public function render(IWigglerContainer $wigglers, null|float|int $interval = null): IFrame
    {
        $frame = $this->prepareFrame($wigglers, $interval);
        $this->writeFrame(
            $frame
        );
        return $frame;
    }

    public function prepareFrame(IWigglerContainer $wigglers, float|int|null $interval): IFrame
    {
        return $this->renderer->renderFrame($wigglers, $interval);
    }

    private function writeFrame(IFrame $frame): void
    {
        $this->writer->write(
            $frame->sequence,
            Sequencer::moveBackSequence($frame->sequenceWidth),
        );
    }

    public function erase(int $i = 1): void
    {
        $this->writer->write(
            Sequencer::eraseSequence($i)
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
