<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;
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
        $this->driver->add($spinner);
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
        $this->driver->remove($spinner);
    }

    public function initialize(): void
    {
        $this->driver->initialize();
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->driver->interrupt($interruptMessage);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->driver->finalize($finalMessage);
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
        $this->driver->update($subject);
    }

    public function render(?float $dt = null): void
    {
        dump(__METHOD__);
        $label = $this->createLabel(__FUNCTION__);

        $this->stopwatch->start($label);
        $this->driver->render($dt);
        $this->stopwatch->stop($label);
    }

//    public function attach(IObserver $observer): void
//    {
//        parent::attach($observer);
//    }

//    public function detach(IObserver $observer): void
//    {
//        parent::detach($observer);
//    }

//    public function notify(): void
//    {
//        $this->driver->notify();
//    }
}
