<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark;

use LogicException;

class Measurement
{
    protected const COUNT = 100;
    protected array $data = [];
    protected int|float $average;
    protected int $count = 0;

    public function add(int $value): void
    {
        $this->count++;
        $this->data[] = $value;
        $this->calculate();
    }

    private function calculate(): void
    {
        if (count($this->data) < self::COUNT) {
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

    public function getActualCount(): int
    {
        return $this->count;
    }

    public function getRequiredCount(): int
    {
        return self::COUNT;
    }

    public function getUnits(): string
    {
        return 'μs';
    }
}
