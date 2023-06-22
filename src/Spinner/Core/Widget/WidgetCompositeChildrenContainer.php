<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\INullableIntervalContainer;
use AlecRabbit\Spinner\Core\NullableIntervalContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\LogicException;
use Traversable;
use WeakMap;

final class WidgetCompositeChildrenContainer extends ASubject implements IWidgetCompositeChildrenContainer
{
    protected ?IInterval $interval = null;

    public function __construct(
        protected readonly WeakMap $map = new WeakMap(),
        protected readonly INullableIntervalContainer $intervalContainer = new NullableIntervalContainer(),
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
    }

    public function update(ISubject $subject): void
    {
        $this->assertNotSelf($subject);

        if ($subject instanceof IWidgetContext && $this->has($subject)) {
            // TODO (2023-06-21 15:22) [Alec Rabbit]: implement
        }
    }

    public function has(IWidgetContext $context): bool
    {
        return $this->map->offsetExists($context);
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        if (!$this->has($context)) {
            $this->map->offsetSet($context, $context);
            $context->attach($this);
            $this->checkInterval($context);
        }
        return $context;
    }

    protected function checkInterval(IWidgetContext $context): void
    {
        $interval = $context->getWidget()?->getInterval();
        $this->intervalContainer->add($interval);
        if ($interval instanceof IInterval && $interval->smallest($this->interval) === $interval) {
            $this->notify();
        }
    }

    public function getInterval(): IInterval
    {
        if ($this->interval === null) {
            throw new LogicException('Interval is not set.');
        }
        return $this->interval;
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
