<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Sequencer;

abstract readonly class ADriver implements IDriver
{
    public function __construct(
        protected IOutput $output,
        protected ITimer $timer,
        protected bool $hideCursor,
        protected string $interruptMessage,
        protected string $finalMessage,
    ) {
    }

    public function erase(IFrame $frame): void
    {
        $this->output->write(
            Sequencer::eraseSequence($frame->width())
        );
    }

    public function display(IFrame $frame, int $widthDiff = 0): void
    {
        $this->output->write(
            [
                $frame->sequence(),
                $widthDiff > 0 ? Sequencer::eraseSequence($widthDiff) : '',
                Sequencer::moveBackSequence($frame->width()),
            ]
        );
    }

    public function hideCursor(): void
    {
        if ($this->hideCursor) {
            $this->output->write(
                Sequencer::hideCursorSequence()
            );
        }
    }

    public function showCursor(): void
    {
        if ($this->hideCursor) {
            $this->output->write(
                Sequencer::showCursorSequence()
            );
        }
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->output->write($interruptMessage ?? $this->interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->output->write($finalMessage ?? $this->finalMessage);
    }

    public function elapsedTime(): float
    {
        return $this->timer->elapsed();
    }
}
