<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;

final class StopwatchFactory implements IStopwatchFactory
{
    public function __construct(
        protected IStopwatchBuilder $builder,
        protected ITimer $timer,
        protected IMeasurementFactory $measurementFactory,
    ) {
    }

    public function create(): IStopwatch
    {
        return $this->builder
            ->withTimer($this->timer)
            ->withMeasurementFactory($this->measurementFactory)
            ->build()
        ;
    }
}
