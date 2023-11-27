<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Stopwatch\Stopwatch;
use LogicException;

final class StopwatchBuilder implements IStopwatchBuilder
{
    private ?ITimer $timer = null;
    private ?IMeasurementFactory $measurementFactory = null;

    public function build(): IStopwatch
    {
        $this->validate();

        return new Stopwatch(
            timer: $this->timer,
            measurementFactory: $this->measurementFactory,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->timer === null => throw new LogicException('Timer is not set.'),
            $this->measurementFactory === null => throw new LogicException('Measurement factory is not set.'),
            default => null,
        };
    }

    public function withTimer(ITimer $timer): IStopwatchBuilder
    {
        $clone = clone $this;
        $clone->timer = $timer;
        return $clone;
    }

    public function withMeasurementFactory(IMeasurementFactory $measurementFactory): IStopwatchBuilder
    {
        $clone = clone $this;
        $clone->measurementFactory = $measurementFactory;
        return $clone;
    }
}
