<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\DTO\DriverSettingsDTO;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Sequencer;

abstract class ADriver implements IDriver
{
    protected IFrame $currentFrame;
    protected int $previousFrameWidth = 0;

    public function __construct(
        protected readonly IOutput $output,
        protected readonly ITimer $timer,
        protected readonly DriverSettingsDTO $driverSettings,
    ) {
    }

    public function erase(): void
    {
        $this->output->write(
            Sequencer::eraseSequence($this->currentFrame->width())
        );
    }

    public function display(): void
    {
        $width = $this->currentFrame->width();
        $widthDiff = $this->calculateWidthDiff($width);

        $this->output->write(
            [
                $this->currentFrame->sequence(),
                $widthDiff > 0 ? Sequencer::eraseSequence($widthDiff) : '',
                Sequencer::moveBackSequence($width),
            ]
        );
    }

    protected function calculateWidthDiff(int $currentWidth): int
    {
        $diff = max($this->previousFrameWidth - $currentWidth, 0);

        $this->previousFrameWidth = $currentWidth;

        return $diff;
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage ?? $this->driverSettings->interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->showCursor();
        $this->output->write($finalMessage ?? $this->driverSettings->finalMessage);
    }

    public function showCursor(): void
    {
        if ($this->driverSettings->hideCursor) {
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
        if ($this->driverSettings->hideCursor) {
            $this->output->write(
                Sequencer::hideCursorSequence()
            );
        }
    }

    public function setCurrentFrame(IFrame $frame): void
    {
        $this->currentFrame = $frame;
    }
}
