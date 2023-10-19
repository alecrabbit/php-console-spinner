<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch;

use AlecRabbit\Stopwatch\Contract\IMeasurement;
use AlecRabbit\Stopwatch\Contract\IStopwatch;
use AlecRabbit\Stopwatch\Contract\ITimer;
use AlecRabbit\Stopwatch\Contract\TimeUnit;
use RuntimeException;

class Stopwatch implements IStopwatch
{
    protected const KEY_GLUE = ':';
    protected const COUNT = 100;

    protected array $current = [];
    protected array $measurements = [];

    public function __construct(
        protected readonly ITimer $timer,
        protected readonly int $requiredMeasurements = self::COUNT,
    ) {
    }

    public function start(string $label, string ...$labels): void
    {
        $key = $this->getKey($label, $labels);
        if (isset($this->current[$key])) {
            throw new RuntimeException('Already started.');
        }
        $this->current[$key] = $this->timer->now();
    }

    protected function getKey(string $label, array $labels): string
    {
        return $label . self::KEY_GLUE . implode(self::KEY_GLUE, $labels);
    }

    public function stop(string $label, string ...$labels): void
    {
        $now = $this->timer->now();

        $key = $this->getKey($label, $labels);

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
            new Measurement(
                $this->timer->getUnit(),
                $this->getRequiredMeasurements(),
            );
    }

    /** @inheritDoc */
    public function getUnit(): TimeUnit
    {
        return $this->timer->getUnit();
    }

    /** @inheritDoc */
    public function getRequiredMeasurements(): int
    {
        return $this->requiredMeasurements;
    }

    public function getMeasurements(): iterable
    {
        return $this->measurements;
    }
}
