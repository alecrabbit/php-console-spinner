<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

use const PHP_EOL;

final class Spinner implements ISpinner
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

    public function message(IMessageWiggler|string|null $message): void
    {
        $this->updateWiggler(IMessageWiggler::class, $message);
    }

    public function finalize(): void
    {
        if (!$this->interrupted) {
            $this->stop();
            $this->driver->message($this->finalMessage);
        }
    }
}
