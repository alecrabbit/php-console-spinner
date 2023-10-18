<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark;

use AlecRabbit\Spinner\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Benchmark\Contract\IStopwatch;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;

final class BenchmarkingDriver extends ASubject implements IBenchmarkingDriver
{
    private string $shortName;

    public function __construct(
        protected readonly IDriver $driver,
        protected readonly IStopwatch $stopwatch,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->shortName = (new \ReflectionClass($this))->getShortName();
        $this->driver->attach($this);
    }

    public function getStopwatch(): IStopwatch
    {
        return $this->stopwatch;
    }

    public function add(ISpinner $spinner): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->add(...),
            $spinner
        );
    }

    protected function benchmark(string $func, Closure $callback, mixed ...$args): void
    {
        $label = $this->createLabel($func);

        $this->stopwatch->start($label);
        $callback(...$args);
        $this->stopwatch->stop($label);
    }

    private function createLabel(string $func): string
    {
        return $this->shortName . '::' . $func . '()';
    }

    public function has(ISpinner $spinner): bool
    {
        return $this->driver->has($spinner);
    }

    public function remove(ISpinner $spinner): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->remove(...),
            $spinner
        );
    }

    public function initialize(): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->initialize(...),
        );
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->interrupt(...),
            $interruptMessage
        );
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->finalize(...),
            $finalMessage
        );
    }

    public function wrap(Closure $callback): Closure
    {
        return $this->driver->wrap($callback);
    }

    public function getInterval(): IInterval
    {
        return $this->driver->getInterval();
    }

    public function update(ISubject $subject): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->update(...),
            $subject
        );
        $this->benchmark(
            __FUNCTION__,
            $this->notify(...),
        );
    }

    public function render(?float $dt = null): void
    {
        $this->benchmark(
            __FUNCTION__,
            $this->driver->render(...),
            $dt
        );
    }
}
