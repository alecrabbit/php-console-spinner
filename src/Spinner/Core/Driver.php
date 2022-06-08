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

    public function render(IWigglerContainer $wigglers, null|float|int $interval = null): void
    {
        $this->writeFrame(
            $this->prepareFrame($wigglers, $interval)
        );
    }

    private function writeFrame(IFrame $frame): void
    {
        $this->writer->write(
            $frame->sequence,
            Sequencer::moveBackSequence($frame->sequenceWidth),
        );
    }

    private function prepareFrame(IWigglerContainer $wigglers, float|int|null $interval): IFrame
    {
        return $this->renderer->renderFrame($wigglers, $interval);
    }

    public function erase(): void
    {
        $this->writer->write(
            Sequencer::eraseSequence()
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
