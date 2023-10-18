<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Exception\LogicException;

final class BenchmarkingDriverBuilder implements IDriverBuilder
{
    private ?IDriverOutput $driverOutput = null;
    private ?ITimer $timer = null;
    private ?IInterval $initialInterval = null;
    private ?IObserver $observer = null;

    public function withDriverOutput(IDriverOutput $driverOutput): IDriverBuilder
    {
        $clone = clone $this;
        $clone->driverOutput = $driverOutput;
        return $clone;
    }

    public function withTimer(ITimer $timer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->timer = $timer;
        return $clone;
    }

    public function withInitialInterval(IInterval $interval): IDriverBuilder
    {
        $clone = clone $this;
        $clone->initialInterval = $interval;
        return $clone;
    }

    public function withObserver(IObserver $observer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->observer = $observer;
        return $clone;
    }

    /** @inheritDoc */
    public function build(): IDriver
    {
        $this->validate();

        return
            new BenchmarkingDriver(
                output: $this->driverOutput,
                timer: $this->timer,
                initialInterval: $this->initialInterval,
                observer: $this->observer,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->driverOutput === null => throw new LogicException('DriverOutput is not set.'),
            $this->timer === null => throw new LogicException('Timer is not set.'),
            $this->initialInterval === null => throw new LogicException('InitialInterval is not set.'),
            default => null,
        };
    }
}
