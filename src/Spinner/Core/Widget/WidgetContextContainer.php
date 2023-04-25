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

final readonly class WidgetContextContainer implements IWidgetContextContainer
{
    public function __construct(
        protected WeakMap $map = new WeakMap(),
    ) {
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        $this->map->offsetSet($context, $context);

        return $context;
    }

    public function remove(IWidgetContext $context): void
    {
        if ($this->map->offsetExists($context)) {
            $this->map->offsetUnset($context);
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
        // TODO: Implement getIntervalContainer() method.
    }
}
