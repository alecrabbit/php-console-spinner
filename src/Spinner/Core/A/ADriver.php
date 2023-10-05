<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use Closure;

abstract class ADriver extends ASubject implements IDriver
{
    protected IInterval $interval;

    public function __construct(
        protected readonly IDriverOutput $output,
        protected readonly ITimer $timer,
        protected readonly IInterval $initialInterval,
        protected readonly ILegacyDriverSettings $driverSettings,
        protected readonly IDriverConfig $driverConfig,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $this->initialInterval;
    }

    /** @inheritDoc */
    public function interrupt(?string $interruptMessage = null): void
    {
        $this->finalize($interruptMessage ?? $this->getInterruptMessage());
    }

    /** @inheritDoc */
    public function finalize(?string $finalMessage = null): void
    {
        $this->erase();
        $this->output->finalize($finalMessage ?? $this->getFinalMessage());
    }

    abstract protected function erase(): void;

    protected function getFinalMessage(): ?string
    {
        return null;
    }

    protected function getInterruptMessage(): ?string
    {
        return null;
    }

    /** @inheritDoc */
    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    /** @inheritDoc */
    public function wrap(Closure $callback): Closure
    {
        return
            function (mixed ...$args) use ($callback): void {
                $this->erase();
                $callback(...$args);
                $this->render();
            };
    }

    abstract public function render(?float $dt = null): void;

    /** @inheritDoc */
    public function initialize(): void
    {
        $this->output->initialize();
    }
}
