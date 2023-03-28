<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\DTO\DriverSettingsDTO;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

abstract class ADriver implements IDriver
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    protected IFrame $currentFrame;
    protected int $previousFrameWidth = 0;

    public function __construct(
        protected readonly IBufferedOutput $output,
        protected readonly ICursor $cursor,
        protected readonly ITimer $timer,
        protected readonly DriverSettingsDTO $driverSettings,
    ) {
    }

    public function display(): void
    {
        $width = $this->currentFrame->width();
        $widthDiff = $this->calculateWidthDiff($width);

        $this->output
            ->bufferedWrite($this->currentFrame->sequence())
            ->flush();

        $this->cursor->erase(max($widthDiff, 0));
        $this->cursor->moveLeft($width);

        $this->output->flush();
    }

    protected function calculateWidthDiff(int $currentWidth): int
    {
        $diff = max($this->previousFrameWidth - $currentWidth, 0);

        $this->previousFrameWidth = $currentWidth;

        return $diff;
    }

    public function erase(): void
    {
        $this->cursor
            ->erase($this->currentFrame->width())
            ->flush();
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
        $this->cursor->show();
    }

    public function elapsedTime(): float
    {
        return $this->timer->elapsed();
    }

    public function initialize(): void
    {
        $this->cursor->hide();
    }

    public function setCurrentFrame(IFrame $frame): void
    {
        $this->currentFrame = $frame;
    }
}
