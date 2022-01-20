<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Exception\MethodNotImplementedException;

final class Spinner implements ISpinner
{
    private const FRAME_INTERVAL = 0.1;
    private bool $synchronous;
    private IDriver $driver;
    private Core\Color $colors;
    private Core\Frame $frames;
    private bool $active;

    public function __construct(
        ISpinnerConfig $config
    ) {
        $this->synchronous = $config->isSynchronous();
        $this->driver = $config->getDriver();
        $this->colors = $config->getColors();
        $this->frames = $config->getFrames();
    }

    public function interval(): int|float
    {
        return self::FRAME_INTERVAL;
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
            $this->driver->write($this->render());
        }
    }

    private function render(): string
    {
        return
            $this->driver->frameSequence(
                $this->colors->next(),
                $this->frames->next()
            )
            . $this->driver->moveBackSequence();
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    public function isAsynchronous(): bool
    {
        return !$this->isSynchronous();
    }

    public function disable(): void
    {
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
