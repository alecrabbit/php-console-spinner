<?php

declare(strict_types=1);
// 25.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetIntervalContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use WeakMap;

final class WidgetContextContainer implements IWidgetContextContainer
{
    protected int $count = 0;

    public function __construct(
        protected readonly WeakMap $map = new WeakMap(),
        protected readonly IWidgetIntervalContainer $intervalContainer = new WidgetIntervalContainer(),
    ) {
        $this->updateCount();
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        $this->map->offsetSet($context, $context);
        $this->intervalContainer->add($context->getWidget()->getInterval());
        $this->updateCount();
        return $context;
    }

    public function remove(IWidgetContext $context): void
    {
        if ($this->map->offsetExists($context)) {
            $this->map->offsetUnset($context);
            $this->intervalContainer->remove($context->getWidget()->getInterval());
            $this->updateCount();
        }
    }

    /**
     * @deprecated Questionable method
     */
    public function find(IWidget $widget): IWidgetContext
    {
        $context = $widget->getContext();
        return $this->get($context);
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

    public function getIntervalContainer(): IWidgetIntervalContainer
    {
        return $this->intervalContainer;
    }

    public function count(): int
    {
        return $this->count;
    }

    protected function updateCount(): void
    {
        $this->count = $this->map->count();
    }

    public function getIterator(): \Traversable
    {
        return $this->map;
    }
}
