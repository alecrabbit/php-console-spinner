<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\IWrapper;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use WeakMap;

final class Driver implements IDriver
{
    /** @var WeakMap<ISpinner, ISpinner> */
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
        /** @var ISpinner $spinner */
        foreach ($this->spinners as $spinner) {
            $this->renderFrame($spinner->update($dt));
        }
    }

    protected function renderFrame(ISpinner $spinner): void
    {
        // TODO (2023-04-09 12:41) [Alec Rabbit]: Implement renderOne() method.
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
}
