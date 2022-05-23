<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IMessage;
use AlecRabbit\Spinner\Core\Contract\IProgress;
use AlecRabbit\Spinner\Core\Contract\IRotator;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Exception\MethodNotImplementedException;

final class Rotator implements IRotator
{
    private bool $synchronous;
    private IDriver $driver;
    private bool $active;
    private int|float $interval;

//    private IRenderer $renderer;

    public function __construct(
        ISpinnerConfig $config
    ) {
        $this->synchronous = $config->isSynchronous();
        $this->driver = $config->getDriver();
        $this->interval = $config->getInterval();
//        $this->renderer = $config->getRenderer();
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    public function refreshInterval(): int|float
    {
        return $this->interval;
    }

    public function begin(): void
    {
        $this->driver->hideCursor();
        $this->start();
    }

    private function start(): void
    {
        $this->active = true;
    }

    public function end(): void
    {
        $this->erase();
        $this->driver->showCursor();
        $this->stop();
    }

    public function erase(): void
    {
        $this->driver->erase();
    }

    private function stop(): void
    {
        $this->active = false;
    }

    public function rotate(): void
    {
        if ($this->active) {
            $this->render();
        }
    }

    private function render(): void
    {
        $this->driver->render(
            $this->interval,
        );
    }

    public function isAsynchronous(): bool
    {
        return !$this->isSynchronous();
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
}
