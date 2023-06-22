<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalContainer;
use AlecRabbit\Spinner\Core\IntervalContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Traversable;
use WeakMap;

final class WidgetContextContainer implements IWidgetContextContainer
{
    protected int $count = 0;

    public function __construct(
        protected readonly WeakMap $map = new WeakMap(),
        protected readonly IIntervalContainer $intervalContainer = new IntervalContainer(),
    ) {
        $this->updateCount();
    }

    protected function updateCount(): void
    {
        $this->count = $this->map->count();
    }

    public function count(): int
    {
        return $this->count;
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        $this->map->offsetSet($context, $context);
        $this->intervalContainer->add($context->getWidget()?->getInterval());
        $this->updateCount();
        return $context;
    }

    public function getInterval(): ?IInterval
    {
        return $this->intervalContainer->getSmallest();
    }

    public function remove(IWidgetContext $context): void
    {
        if ($this->map->offsetExists($context)) {
            $this->map->offsetUnset($context);
            $this->intervalContainer->remove($context->getWidget()?->getInterval());
            $this->updateCount();
        }
    }

    public function get(IWidgetContext $context): IWidgetContext
    {
        if ($this->map->offsetExists($context)) {
            return $this->map->offsetGet($context);
        }
        throw new InvalidArgumentException('Context not found.');
    }

    public function has(IWidgetContext $context): bool
    {
        return $this->map->offsetExists($context);
    }

    public function getIterator(): Traversable
    {
        return $this->map;
    }
}
