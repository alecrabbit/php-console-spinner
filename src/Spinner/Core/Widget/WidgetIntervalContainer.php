<?php

declare(strict_types=1);
// 25.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetIntervalContainer;
use WeakMap;

final class WidgetIntervalContainer implements IWidgetIntervalContainer
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
        if (null === $this->smallest) {
            $this->smallest = $interval;
            return;
        }
        $this->smallest = $this->smallest->smallest($interval);
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
