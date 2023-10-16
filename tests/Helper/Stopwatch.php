<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper;

use AlecRabbit\Tests\Helper\Contract\IStopwatch;

class Stopwatch implements IStopwatch
{
    protected const KEY_GLUE = ':';
    protected array $current = [];
    protected array $measurements = [];

    public function start(string $label, string ...$labels): void
    {
        $key = $this->getKey($label, $labels);
        if (isset($this->current[$key])) {
            throw new \RuntimeException('Already started');
        }
        $this->current[$key] = $this->getNow();
    }

    protected function getKey(string $label, array $labels): string
    {
        return $label . self::KEY_GLUE . implode(self::KEY_GLUE, $labels);
    }

    protected function getNow(): int
    {
        return (int)(microtime(true) * 1_000_000); // microseconds
    }

    public function stop(string $label, string ...$labels): void
    {
        $now = $this->getNow();

        $key = $this->getKey($label, $labels);

        if (isset($this->current[$key])) {
            $this->addMeasurement($key, $now - $this->current[$key]);
            unset($this->current[$key]);
        }
    }

    protected function addMeasurement(string $key, mixed $value): void
    {
        if (!isset($this->measurements[$key])) {
            $this->measurements[$key] = new Measurement();
        }
        /** @var Measurement $m */
        $m = $this->measurements[$key];
        $m->add($value);
    }

    public function getMeasurements(): iterable
    {
        return $this->measurements;
    }
}
