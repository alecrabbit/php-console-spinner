<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template TKey of IWIdgetContext
 * @template TValue of IInterval|null
 *
 * @extends ArrayAccess<TKey, TValue>
 * @extends IteratorAggregate<TKey, TValue>
 */
interface IWidgetContextToIntervalMap extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @psalm-return Traversable<TKey, TValue>
     */
    public function getIterator(): Traversable;

    /**
     * @psalm-param IWidgetContext $offset
     *
     * @psalm-return IInterval
     */
    public function offsetGet(mixed $offset): ?IInterval;

    /**
     * @psalm-param IWidgetContext $offset
     */
    public function offsetUnset(mixed $offset): void;

    /**
     * @psalm-param IWidgetContext $offset
     * @psalm-param IInterval $value
     */
    public function offsetSet(mixed $offset, mixed $value): void;

    /**
     * @psalm-param IWidgetContext $offset
     *
     * @psalm-return bool
     */
    public function offsetExists(mixed $offset): bool;
}
