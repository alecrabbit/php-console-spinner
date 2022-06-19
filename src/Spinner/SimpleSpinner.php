<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ISimpleSpinner;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;

use const PHP_EOL;

final class SimpleSpinner implements ISimpleSpinner
{
    private readonly IDriver $driver;
    private readonly string $finalMessage;
    private readonly string $interruptMessage;
    private bool $interrupted = false;

    private bool $active;
    private IWigglerContainer $wigglers;
    private ?IFrame $currentFrame = null;

    public function __construct(IConfig $config)
    {
        $this->driver = $config->getDriver();
        $this->wigglers = $config->getWigglers();
        $this->finalMessage = $config->getFinalMessage();
        $this->interruptMessage = $config->getInterruptMessage();
    }

    public function getInterval(): IInterval
    {
        return $this->wigglers->getInterval();
    }

    public function initialize(): void
    {
        $this->driver->hideCursor();
        $this->start();
    }

    private function start(): void
    {
        $this->active = true;
    }

    public function resume(): void
    {
        $this->active = true;
    }

    public function spinner(IRevolveWiggler|string|null $wiggler): void
    {
        $this->wrap(
            $this->wigglers->spinner(...),
            $wiggler
        );
    }

    public function wrap(callable $callback, ...$args): void
    {
        $this->erase();
        $callback(...$args);
        $this->spin();
    }

    public function erase(): void
    {
        $this->driver->erase(
            $this->currentFrame?->sequenceWidth
        );
    }

    public function spin(): void
    {
        if ($this->active) {
            $this->render();
            $this->driver->writeFrame($this->currentFrame);
        }
    }

    private function render(): void
    {
        $this->currentFrame = $this->wigglers->render();
    }

    public function progress(string|IProgressWiggler|float|null $wiggler): void
    {
        $this->wrap(
            $this->wigglers->progress(...),
            $wiggler
        );
    }

    public function interrupt(): void
    {
        $this->interrupted = true;
        $this->stop();
        $this->driver->message(PHP_EOL . $this->interruptMessage);
    }

    private function stop(): void
    {
        $this->pause();
        $this->driver->showCursor();
    }

    public function pause(): void
    {
        $this->erase();
        $this->active = false;
    }

    public function message(string|IMessageWiggler|null $wiggler): void
    {
        $this->wrap(
            $this->wigglers->message(...),
            $wiggler
        );
    }

    public function finalize(): void
    {
        if (!$this->interrupted) {
            $this->stop();
            $this->driver->message($this->finalMessage);
        }
    }
}
