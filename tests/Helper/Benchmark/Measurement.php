<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

use LogicException;

class Measurement implements Contract\IMeasurement
{
    protected const REQUIRED_COUNT = 2;
    protected array $data = [];
    protected int|float $average;
    protected int|float $min;
    protected int|float $max;
    protected int $count = 0;

    public function __construct(
        protected readonly int $requiredCount = self::REQUIRED_COUNT,
    ) {
    }

    public function add(int|float $value): void
    {
        $this->count++;
        $this->data[] = $value;
        $this->calculate($value);
    }

    private function calculate(int $value): void
    {
        if(!isset($this->min) || $value < $this->min) {
            $this->min = $value;
        }

        if(!isset($this->max) || $value > $this->max) {
            $this->max = $value;
        }

        if (count($this->data) < $this->requiredCount) {
            return;
        }
        $this->updateAverage();
    }

    protected function updateAverage(): void
    {
        $average = array_sum($this->data) / count($this->data);
        $this->average = ($average + ($this->average ?? $average)) / 2;
        $this->data = [];
    }

    public function getAverage(): int|float
    {
        return $this->average ?? throw new LogicException('Not enough data.');
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
}
