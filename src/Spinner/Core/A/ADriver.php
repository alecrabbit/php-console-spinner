<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Sequencer;

abstract class ADriver implements IDriver
{
    protected int $previousFrameWidth = 0;

    public function __construct(
        protected readonly IOutput $output,
        protected readonly ITimer $timer,
        protected readonly bool $hideCursor,
        protected readonly string $interruptMessage,
        protected readonly string $finalMessage,
    ) {
    }

    public function erase(IFrame $frame): void
    {
        $this->output->write(
            Sequencer::eraseSequence($frame->width())
        );
    }

    public function display(IFrame $frame): void
    {
        $widthDiff = $this->calculateWidthDiff($frame);

        $this->output->write(
            [
                $frame->sequence(),
                $widthDiff > 0 ? Sequencer::eraseSequence($widthDiff) : '',
                Sequencer::moveBackSequence($frame->width()),
            ]
        );
    }

    private function calculateWidthDiff(IFrame $frame): mixed
    {
        $diff = max($this->previousFrameWidth - $frame->width(), 0);

        $this->previousFrameWidth = $frame->width();

        return $diff;
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage ?? $this->interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->showCursor();
        $this->output->write($finalMessage ?? $this->finalMessage);
    }

    public function showCursor(): void
    {
        if ($this->hideCursor) {
            $this->output->write(
                Sequencer::showCursorSequence()
            );
        }
    }

    public function elapsedTime(): float
    {
        return $this->timer->elapsed();
    }

    public function initialize(): void
    {
        $this->hideCursor();
    }

    public function hideCursor(): void
    {
        if ($this->hideCursor) {
            $this->output->write(
                Sequencer::hideCursorSequence()
            );
        }
    }
}
