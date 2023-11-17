<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @template TKey
 * @template TValue
 *
 * @extends ArrayAccess<TKey, TValue>
 * @extends IteratorAggregate<TKey, TValue>
 */
interface IWeakMap extends ArrayAccess, Countable, IteratorAggregate
{
}
