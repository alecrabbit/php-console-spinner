<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use RuntimeException;

class Stopwatch implements IStopwatch
{
    protected const COUNT = 100;

    protected array $current = [];
    protected array $measurements = [];

    public function __construct(
        protected readonly ITimer $timer,
        protected readonly IMeasurementFactory $measurementFactory,
    ) {
    }

    public function start(string $key): void
    {
        if (isset($this->current[$key])) {
            throw new RuntimeException('Already started.');
        }
        $this->current[$key] = $this->timer->now();
    }

    public function stop(string $key): void
    {
        $now = $this->timer->now();

        if (isset($this->current[$key])) {
            $this->addMeasurement($key, $now - $this->current[$key]);
            unset($this->current[$key]);
        }
    }

    protected function addMeasurement(string $key, mixed $value): void
    {
        if (!isset($this->measurements[$key])) {
            $this->measurements[$key] = $this->createMeasurement();
        }
        $this->measurements[$key]->add($value);
    }

    protected function createMeasurement(): IMeasurement
    {
        return
            $this->measurementFactory->create();
    }

    /** @inheritDoc */
    public function getUnit(): TimeUnit
    {
        return $this->timer->getUnit();
    }

    public function getMeasurements(): iterable
    {
        return $this->measurements;
    }
}
