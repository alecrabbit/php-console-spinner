<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark;

use LogicException;

class Measurement implements Contract\IMeasurement
{
    protected const DEFAULT_THRESHOLD = 2;
    protected const DEFAULT_LABEL = '--undefined--';
    protected array $data = [];
    protected int|float $average;
    protected int|float $min;
    protected int|float $max;
    protected int $count = 0;

    public function __construct(
        protected readonly int $threshold = self::DEFAULT_THRESHOLD,
        protected readonly string $label = self::DEFAULT_LABEL,
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
        if (count($this->data) >= $this->threshold) {
            $average = array_sum($this->data) / count($this->data);
            $this->average = ($average + ($this->average ?? $average)) / 2;
            $this->data = [];
        }
    }

    public function getAverage(): int|float
    {
        return $this->average ?? throw new LogicException('Not enough data.');
    }

    public function getAny(): int|float
    {
        $count = count($this->data);

        if ($count > 0) {
            return array_sum($this->data) / $count;
        }

        throw new LogicException('Can not return any.');
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getMin(): int|float
    {
        return $this->min ?? throw new LogicException('Min is not set.');
    }

    public function getMax(): int|float
    {
        return $this->max ?? throw new LogicException('Max is not set.');
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
