<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

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
     * @psalm-param TKey $offset
     *
     * @psalm-return TValue
     */
    public function offsetGet(mixed $offset): ?IInterval;

    /**
     * @psalm-param TKey $offset
     */
    public function offsetUnset(mixed $offset): void;

    /**
     * @psalm-param TKey $offset
     * @psalm-param TValue $value
     */
    public function offsetSet(mixed $offset, mixed $value): void;

    /**
     * @psalm-param TKey $offset
     *
     * @psalm-return bool
     */
    public function offsetExists(mixed $offset): bool;
}
