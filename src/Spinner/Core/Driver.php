<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use WeakMap;

final class Driver implements IDriver
{
    /** @var WeakMap<ISpinner, int> */
    protected WeakMap $spinners;
    protected bool $initialized = false;

    public function __construct(
        protected readonly IBufferedOutput $output,
        protected readonly ICursor $cursor,
        protected readonly ITimer $timer,
        protected readonly string $interruptMessage,
        protected readonly string $finalMessage,
        protected IInterval $interval,
    ) {
        $this->spinners = new WeakMap();
    }

    public function render(float $dt = null): void
    {
        foreach ($this->spinners as $spinner => $previousWidth) {
            $this->renderFrame($spinner->update($dt), $previousWidth);
        }
    }

    protected function renderFrame(IFrame $frame, int $previousWidth): void
    {
        $width = $frame->width();
        $widthDiff = max($previousWidth - $width, 0);

        $this->output->bufferedWrite($frame->sequence());

        $this->cursor->erase(max($widthDiff, 0));
        $this->cursor->moveLeft($width);

        $this->output->flush();
    }

    protected function erase(?ISpinner $spinner = null): void
    {
        match (true) {
            null === $spinner => $this->eraseAll(),
            default => $this->eraseOne($spinner),
        };
    }

    protected function eraseAll(): void
    {
        foreach ($this->spinners as $spinner) {
            $this->eraseOne($spinner);
        }
    }

    protected function eraseOne(ISpinner $spinner): void
    {
        // TODO (2023-04-09 12:41) [Alec Rabbit]: Implement eraseOne() method.
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage ?? $this->interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        if ($this->initialized) {
            $this->cursor->show();
            $this->output->write($finalMessage ?? $this->finalMessage);
        }
    }

    public function initialize(): void
    {
        $this->cursor->hide();
        $this->initialized = true;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function add(ISpinner $spinner): void
    {
        if (!$this->spinners->offsetExists($spinner)) {
            $this->spinners->offsetSet($spinner, 0);
        }
    }

    public function remove(ISpinner $spinner): void
    {
        if ($this->spinners->offsetExists($spinner)) {
            $this->spinners->offsetUnset($spinner);
        }
    }
}
