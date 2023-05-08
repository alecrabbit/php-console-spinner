<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use Closure;

abstract class ADriver extends ASubject implements IDriver
{
    protected IInterval $interval;

    public function __construct(
        protected readonly IDriverOutput $output,
        protected readonly ITimer $timer,
        protected readonly IInterval $initialInterval,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $this->initialInterval;
    }

    /** @inheritdoc */
    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage);
    }

    /** @inheritdoc */
    public function finalize(?string $finalMessage = null): void
    {
        $this->erase();
        $this->output->finalize($finalMessage);
    }

    /** @inheritdoc */
    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    abstract protected function erase(): void;

    abstract public function render(?float $dt = null): void;

    /** @inheritdoc */
    public function wrap(Closure $callback): Closure
    {
        return
            function (mixed ...$args) use ($callback): void {
                $this->erase();
                $callback(...$args);
                $this->render();
            };
    }
}
