<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\IntervalComparator;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetCompositeChildrenContainer;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template TKey of IWidgetContext
 * @template TValue of IWidgetContext|null
 *
 * @implements IWidgetCompositeChildrenContainer<TKey, TValue>
 */
final class WidgetCompositeChildrenContainer extends ASubject implements IWidgetCompositeChildrenContainer
{
    protected ?IInterval $interval = null;

    public function __construct(
        private readonly ArrayAccess&Countable&IteratorAggregate $map = new WidgetContextToIntervalMap(),
        private readonly IIntervalComparator $intervalComparator = new IntervalComparator(),
        // FIXME (2023-11-21 17:34) [Alec Rabbit]: inject it?
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
    }

    public function update(ISubject $subject): void
    {
        $this->assertNotSelf($subject);

        if ($subject instanceof IWidgetContext && $this->has($subject)) {
            $interval = $subject->getInterval();
            if ($interval !== $this->map->offsetGet($subject)) {
                $this->map->offsetSet($subject, $interval);
                $this->checkInterval($interval);
            }
        }
    }

    public function has(IWidgetContext $context): bool
    {
        return $this->map->offsetExists($context);
    }

    public function getInterval(): ?IInterval
    {
        return $this->interval;
    }

    protected function checkInterval(?IInterval $interval): void
    {
        if ($interval instanceof IInterval) {
            $this->interval = $this->intervalComparator->smallest($interval, $this->interval);
            if ($interval === $this->interval) {
                $this->notify();
            }
        }
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        if (!$this->has($context)) {
            $context->attach($this);

            $interval = $context->getInterval();
            $this->map->offsetSet($context, $interval);
            $this->checkInterval($interval);
        }
        return $context;
    }

    public function getIterator(): Traversable
    {
        return $this->map;
    }

    public function remove(IWidgetContext $context): void
    {
        if ($this->map->offsetExists($context)) {
            $this->map->offsetUnset($context);
            $context->detach($this);

            $interval = $context->getInterval();
            if ($interval === $this->interval) {
                $this->recalculateInterval();
                $this->notify();
            }
        }
    }

    protected function recalculateInterval(): void
    {
        $this->interval = null;
        /** @var IInterval|null $interval */
        foreach ($this->map as $interval) {
            if ($this->interval === null) {
                $this->interval = $interval;
                continue;
            }
            $this->interval = $this->intervalComparator->smallest($this->interval, $interval);
        }
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return $this->map->count();
    }
}
