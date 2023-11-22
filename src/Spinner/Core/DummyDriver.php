<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;

final readonly class DummyDriver implements IDriver
{
    public function __construct(
        private IInterval $initialInterval,
    ) {
    }

    /** @codeCoverageIgnore */
    public function add(ISpinner $spinner): void
    {
        // do nothing
    }

    public function has(ISpinner $spinner): bool
    {
        return false;
    }

    /** @codeCoverageIgnore */
    public function remove(ISpinner $spinner): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function initialize(): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function interrupt(?string $interruptMessage = null): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function finalize(?string $finalMessage = null): void
    {
        // do nothing
    }

    public function wrap(Closure $callback): Closure
    {
        return static fn() => null;
    }

    public function getInterval(): IInterval
    {
        return $this->initialInterval;
    }

    /** @codeCoverageIgnore */
    public function update(ISubject $subject): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function render(?float $dt = null): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function attach(IObserver $observer): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function detach(IObserver $observer): void
    {
        // do nothing
    }

    /** @codeCoverageIgnore */
    public function notify(): void
    {
        // do nothing
    }
}
