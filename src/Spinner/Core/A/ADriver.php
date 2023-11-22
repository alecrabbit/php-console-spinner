<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use Closure;

abstract class ADriver extends ASubject implements IDriver
{
    protected IInterval $interval;
    protected readonly IDriverMessages $messages;

    public function __construct(
        IDriverConfig $driverConfig, // FIXME (2023-11-22 14:51) [Alec Rabbit]: change to `protected readonly IDriverMessages $messages,`
        protected readonly IDeltaTimer $deltaTimer,
        protected readonly IInterval $initialInterval,
        protected readonly ISequenceStateWriter $stateWriter,
        protected readonly ISequenceStateBuilder $stateBuilder,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $this->initialInterval;
        $this->messages = $driverConfig->getDriverMessages();
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage ?? $this->messages->getInterruptionMessage());
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->erase();
        $this->stateWriter->finalize($finalMessage ?? $this->messages->getFinalMessage());
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
        $this->stateWriter->initialize();
    }

    abstract public function has(ISpinner $spinner): bool;
}
