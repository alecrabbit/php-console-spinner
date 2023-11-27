<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Exception\MeasurementException;

final class Measurement implements IMeasurement
{
    private const DEFAULT_THRESHOLD = 2;

    /** @var array<int|float> */
    private array $data = [];
    private int|float $average;
    private int|float $min;
    private int|float $max;
    private int $count = 0;

    public function __construct(
        protected readonly int $threshold = self::DEFAULT_THRESHOLD,
    ) {
    }

    public function add(int|float $value): void
    {
        $this->count++;
        $this->data[] = $value;

        // update min
        if (!isset($this->min) || $value < $this->min) {
            $this->min = $value;
        }

        // update max
        if (!isset($this->max) || $value > $this->max) {
            $this->max = $value;
        }

        // update average
        if ($this->reachedThreshold()) {
            $average = array_sum($this->data) / count($this->data);
            $this->average = ($average + ($this->average ?? $average)) / 2;
            $this->data = [];
        }
    }

    private function reachedThreshold(): bool
    {
        return count($this->data) >= $this->threshold;
    }

    public function getAverage(): int|float
    {
        return $this->average ?? throw new MeasurementException('Not enough data.');
    }

    public function getAny(): int|float
    {
        $count = count($this->data);

        if ($count > 0) {
            return array_sum($this->data) / $count;
        }

        throw new MeasurementException('Can not return any.');
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getMin(): int|float
    {
        return $this->min ?? throw new MeasurementException('Min is not set.');
    }

    public function getMax(): int|float
    {
        return $this->max ?? throw new MeasurementException('Max is not set.');
    }

    public function getThreshold(): int
    {
        return $this->threshold;
    }
}
