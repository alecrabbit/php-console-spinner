<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;

final class BenchmarkingDriver extends ASubject implements IBenchmarkingDriver
{
    public function __construct(
        protected readonly IDriver $driver,
        protected readonly IBenchmark $benchmark,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->driver->attach($this);
    }

    public function add(ISpinner $spinner): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->add(...),
            $spinner
        );
    }

    protected function refineKey(string $func): string
    {
        return $this::class . '::' . $func;
    }

    public function has(ISpinner $spinner): bool
    {
        return $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->has(...),
            $spinner
        );
    }

    public function remove(ISpinner $spinner): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->remove(...),
            $spinner
        );
    }

    public function initialize(): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->initialize(...),
        );
    }

    public function interrupt(?string $interruptMessage = null): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->interrupt(...),
            $interruptMessage
        );
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->finalize(...),
            $finalMessage
        );
    }

    public function wrap(Closure $callback): Closure
    {
        return $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->wrap(...),
            $callback
        );
    }

    public function getInterval(): IInterval
    {
        return $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->getInterval(...),
        );
    }

    public function update(ISubject $subject): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->update(...),
            $subject
        );
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->notify(...),
        );
    }

    public function render(?float $dt = null): void
    {
        $this->benchmark->run(
            $this->refineKey(__FUNCTION__),
            $this->driver->render(...),
            $dt
        );
    }

    public function getBenchmark(): IBenchmark
    {
        return $this->benchmark;
    }
}
