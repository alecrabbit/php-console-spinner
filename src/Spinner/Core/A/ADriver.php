<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;

abstract class ADriver extends ASubject implements IDriver
{
    protected IInterval $interval;

    protected function __construct(
        protected readonly IInterval $initialInterval,
        protected readonly IDriverMessages $driverMessages,
        protected readonly IRenderer $renderer,
        protected readonly IDeltaTimer $deltaTimer,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $this->initialInterval;
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage ?? $this->driverMessages->getInterruptionMessage());
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->erase();
        $this->renderer->finalize($finalMessage ?? $this->driverMessages->getFinalMessage());
    }

    abstract protected function erase(): void;

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function wrap(Closure $callback): Closure
    {
        return function (mixed ...$args) use ($callback): void {
            $this->erase();
            $callback(...$args);
            $this->render();
        };
    }

    abstract public function render(?float $dt = null): void;

    public function initialize(): void
    {
        $this->renderer->initialize();
    }

    abstract public function has(ISpinner $spinner): bool;
}
