<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Exception\MethodNotImplementedException;

final class Spinner implements ISpinner
{
    private bool $synchronous;
    private IDriver $driver;
    private Core\Color $colors;
    private Core\Frame $frames;
    private bool $active;
    private int|float $interval;

    public function __construct(
        ISpinnerConfig $config
    ) {
        $this->synchronous = $config->isSynchronous();
        $this->driver = $config->getDriver();
        $this->colors = $config->getColors();
        $this->frames = $config->getFrames();
        $this->interval = $config->getInterval();
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

    private function erase(): void
    {
        $this->driver->write(
            $this->driver->eraseSequence()
        );
    }

    private function stop(): void
    {
        $this->active = false;
    }

    public function spin(): void
    {
        if ($this->active) {
            $this->render();
        }
    }

    private function render(): void
    {
        $this->driver->write(
            $this->driver->frameSequence(
                $this->colors->next(),
                $this->frames->next()
            )
            . $this->driver->moveBackSequence()
        );
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

    public function message(?string $message): void
    {
        // TODO: Implement message() method.
        // FIXME (2022-01-20 20:52) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }

    public function progress(?float $percent): void
    {
        // TODO: Implement progress() method.
        // FIXME (2022-01-20 20:52) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }
}
