<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Builder;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;

interface IStopwatchBuilder
{
    public function build(): IStopwatch;

    public function withTimer(ITimer $timer): IStopwatchBuilder;

    public function withMeasurementFactory(IMeasurementFactory $measurementFactory): IStopwatchBuilder;
}
