<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Driver;

final class Spinner implements ISpinner
{
    private const FRAME_INTERVAL = 0.1;
    private bool $async;
    private Driver $driver;
    private Core\Color $colors;
    private Core\Frame $frames;
    private bool $running;

    public function __construct(
        private ISpinnerConfig $config
    ) {
        $this->async = $this->config->isAsync();
        $this->driver = new Driver($config->getOutput());
        $this->colors = $this->config->getColors();
        $this->frames = $this->config->getFrames();
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
        $this->running = true;
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
        $this->running = false;
    }

    public function spin(): void
    {
        if ($this->running) {
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

    public function isAsync(): bool
    {
        return $this->async;
    }

    public function disable(): void
    {
        // TODO: Implement disable() method.
    }

    public function enable(): void
    {
        // TODO: Implement enable() method.
    }

    public function message(?string $message): void
    {
        // TODO: Implement message() method.
    }

    public function progress(?float $percent): void
    {
        // TODO: Implement progress() method.
    }
}
