<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use Countable;
use IteratorAggregate;
use Traversable;

interface IWidgetContextContainer extends Countable, IteratorAggregate
{
    public function add(IWidgetContext $context): IWidgetContext;

    public function getIntervalContainer(): IWidgetIntervalContainer;

    public function remove(IWidgetContext $context): void;

    public function get(IWidgetContext $context);

    public function find(IWidget $widget): IWidgetContext;

    public function has(IWidgetContext $context): bool;

    public function count(): int;

    public function getIterator(): Traversable;
}
