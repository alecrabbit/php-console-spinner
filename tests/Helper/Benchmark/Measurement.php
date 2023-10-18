<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

use LogicException;

class Measurement implements Contract\IMeasurement
{
    protected const COUNT = 2;
    protected array $data = [];
    protected int|float $average;
    protected int $count = 0;

    public function __construct(
        protected readonly int $requiredCount = self::COUNT,
    ) {
    }


    public function add(int $value): void
    {
        $this->count++;
        $this->data[] = $value;
        $this->calculate();
    }

    private function calculate(): void
    {
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
        // TODO: Implement getMin() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function getMax(): int|float
    {
        // TODO: Implement getMax() method.
        throw new \RuntimeException('Not implemented.');
    }
}
