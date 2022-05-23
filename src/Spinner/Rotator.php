<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IMessage;
use AlecRabbit\Spinner\Core\Contract\IProgress;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\IRotator;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IWriter;
use AlecRabbit\Spinner\Core\Exception\MethodNotImplementedException;

final class Rotator implements IRotator
{
    private bool $synchronous;
    private ISequencer $sequencer;
    private IWriter $writer;
    private bool $active;
    private int|float $interval;
    private IRenderer $renderer;

    public function __construct(
        ISpinnerConfig $config
    ) {
        $this->synchronous = $config->isSynchronous();
        $this->sequencer = $config->getSequencer();
        $this->writer = $config->getWriter();
        $this->interval = $config->getInterval();
        $this->renderer = $config->getRenderer();
    }

    public function refreshInterval(): int|float
    {
        return $this->interval;
    }

    public function begin(): void
    {
        $this->hideCursor();
        $this->start();
    }

    private function start(): void
    {
        $this->active = true;
    }

    public function end(): void
    {
        $this->erase();
        $this->showCursor();
        $this->stop();
    }

    public function erase(): void
    {
        $this->writer->write(
            $this->sequencer->eraseSequence()
        );
    }

    private function stop(): void
    {
        $this->active = false;
    }

    public function rotate(): void
    {
        if ($this->active) {
            $this->show($this->render());
        }
    }

    private function render(): IFrame
    {
        return $this->renderer->createFrame($this->interval);
    }

    public function isAsynchronous(): bool
    {
        return !$this->isSynchronous();
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    public function disable(): void
    {
        $this->erase();
        $this->active = false;
    }

    public function enable(): void
    {
        $this->active = true;
    }

    public function spinner(?ISpinner $spinner): void
    {
        // TODO: Implement spinner() method.
        // FIXME (2022-05-22 15:22) [Alec Rabbit]: Implement this method.
        throw new MethodNotImplementedException(__METHOD__);
    }

    public function message(null|string|IMessage $message): void
    {
        // TODO: Implement message() method.
        // FIXME (2022-01-20 20:52) [Alec Rabbit]: Implement this method.
        throw new MethodNotImplementedException(__METHOD__);
    }

    public function progress(null|float|IProgress $progress): void
    {
        // TODO: Implement progress() method.
        // FIXME (2022-01-20 20:52) [Alec Rabbit]: Implement this method.
        throw new MethodNotImplementedException(__METHOD__);
    }

    private function show(IFrame $frame): void
    {
        $this->writer->write(
            $this->sequencer->frameSequence($frame->sequence),
            $this->sequencer->moveBackSequence($frame->sequenceWidth),
        );
    }

    private function hideCursor(): void
    {
        $this->writer->write(
            $this->sequencer->hideCursorSequence()
        );
    }

    private function showCursor(): void
    {
        $this->writer->write(
            $this->sequencer->showCursorSequence()
        );
    }
}
