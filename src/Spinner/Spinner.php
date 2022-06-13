<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

final class Spinner implements ISpinner
{
    private readonly bool $hideCursor;
    private readonly bool $synchronous;
    private readonly IDriver $driver;

    private IWigglerContainer $wigglers;
    private bool $active;
    private ?Core\Contract\IFrame $currentFrame = null;

    public function __construct(ISpinnerConfig $config)
    {
        $this->hideCursor = $config->isHideCursor();
        $this->synchronous = $config->isSynchronous();
        $this->driver = $config->getDriver();
        $this->wigglers = $config->getWigglers();
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    public function getInterval(): IInterval
    {
        return $this->wigglers->getInterval();
    }

    public function begin(): void
    {
        if ($this->hideCursor) {
            $this->driver->hideCursor();
        }
        $this->start();
    }

    private function start(): void
    {
        $this->active = true;
    }

    public function end(): void
    {
        $this->erase();
        if ($this->hideCursor) {
            $this->driver->showCursor();
        }
        $this->stop();
    }

    public function erase(): void
    {
        $this->driver->erase(
            $this->currentFrame?->sequenceWidth
        );
    }

    private function stop(): void
    {
        $this->active = false;
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

    public function spinner(IRevolveWiggler|string|null $spinner): void
    {
        $this->updateWiggler(IRevolveWiggler::class, $spinner);
    }

    private function updateWiggler(string $class, IWiggler|string|null $wiggler): void
    {
        $this->erase();
        $this->wigglers->updateWiggler(
            $this->wigglers->getIndex($class),
            $wiggler,
        );
        $this->spin();
    }

    public function spin(): void
    {
        if ($this->active) {
            $this->driver->writeFrame(
                $this->currentFrame = $this->render()
            );
        }
    }

    private function render(): IFrame
    {
        return $this->wigglers->render();
    }

    public function message(IMessageWiggler|string|null $message): void
    {
        $this->updateWiggler(IMessageWiggler::class, $message);
    }

    public function progress(IProgressWiggler|float|null $progress): void
    {
        if (is_float($progress)) {
            $progress = sprintf('%s%%', (int)($progress * 100));
        }
        $this->updateWiggler(IProgressWiggler::class, $progress);
    }

    public function wrap(callable $callback, ...$args): void
    {
        $this->erase();
        $callback(...$args);
        $this->spin();
    }
}
