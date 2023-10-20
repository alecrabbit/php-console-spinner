<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;
use ReflectionClass;

final class BenchmarkingDriver extends ASubject implements IBenchmarkingDriver
{
    private string $shortName;

    public function __construct(
        protected readonly IDriver $driver,
        protected readonly IStopwatch $stopwatch,
        protected readonly IBenchmark $benchmark,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->shortName = (new ReflectionClass($this))->getShortName();
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
        $this->benchmark(
            __FUNCTION__,
            function (ISpinner $spinner) use (&$result): void {
                $result = $this->driver->has($spinner);
            },
            $spinner
        );
        return $result;
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
        $this->benchmark(
            __FUNCTION__,
            function (Closure $callback) use (&$result): void {
                $result = $this->driver->wrap($callback);
            },
            $callback
        );
        return $result;
    }

    public function getInterval(): IInterval
    {
        $this->benchmark(
            __FUNCTION__,
            function () use (&$result): void {
                $result = $this->driver->getInterval();
            },
        );
        return $result;
    }

    public function update(ISubject $subject): void
    {
        $this->benchmark(
            __FUNCTION__ . '[update]',
            $this->driver->update(...),
            $subject
        );
        $this->benchmark(
            __FUNCTION__ . '[notify]',
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
