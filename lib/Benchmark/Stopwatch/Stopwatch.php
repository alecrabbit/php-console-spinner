<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use RuntimeException;
use Traversable;

final class Stopwatch implements IStopwatch
{
    /** @var array<string> */
    private array $current = [];

    /** @var array<IMeasurement> */
    private array $measurements = [];

    public function __construct(
        private readonly ITimer $timer,
        private readonly IMeasurementFactory $measurementFactory,
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

    private function addMeasurement(string $key, mixed $value): void
    {
        if (!isset($this->measurements[$key])) {
            $this->measurements[$key] = $this->createMeasurement();
        }
        $this->measurements[$key]->add($value);
    }

    private function createMeasurement(): IMeasurement
    {
        return $this->measurementFactory->create();
    }

    public function getMeasurements(): Traversable
    {
        foreach ($this->measurements as $key => $measurement) {
            yield $key => $measurement;
        }
    }
}
