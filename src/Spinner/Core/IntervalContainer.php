<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalContainer;
use WeakMap;

final class IntervalContainer implements IIntervalContainer
{
    protected ?IInterval $smallest = null;

    public function __construct(
        protected readonly WeakMap $map = new WeakMap(),
    ) {
    }

    public function getSmallest(): ?IInterval
    {
        return $this->smallest;
    }

    public function add(IInterval $interval): void
    {
        $this->map->offsetSet($interval, $interval);
        $this->updateSmallestOnAdd($interval);
    }

    private function updateSmallestOnAdd(IInterval $interval): void
    {
        $this->smallest = $interval->smallest($this->smallest);
    }

    public function remove(IInterval $interval): void
    {
        if ($this->map->offsetExists($interval)) {
            $this->map->offsetUnset($interval);
            $this->updateSmallestOnRemove($interval);
        }
    }

    private function updateSmallestOnRemove(IInterval $interval): void
    {
        if ($interval === $this->smallest) {
            $this->smallest = null;
            foreach ($this->map as $i) {
                $this->updateSmallestOnAdd($i);
            }
        }
    }
}
