<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\INullableIntervalContainer;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use WeakMap;

final class NullableIntervalContainer extends ASubject implements INullableIntervalContainer
{
    protected ?IInterval $smallest = null;

    public function __construct(
        protected readonly ArrayAccess&Countable&IteratorAggregate $map = new WeakMap(),
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
    }

    public function getSmallest(): ?IInterval
    {
        return $this->smallest;
    }

    public function add(?IInterval $interval): void
    {
        if (null === $interval) {
            return;
        }
        $this->map->offsetSet($interval, $interval);
        $this->updateSmallestOnAdd($interval);
    }

    private function updateSmallestOnAdd(IInterval $interval): void
    {
        $this->smallest = $interval->smallest($this->smallest);
    }

    public function remove(?IInterval $interval): void
    {
        if (null === $interval) {
            return;
        }
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
