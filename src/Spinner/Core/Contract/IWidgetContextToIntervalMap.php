<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use ArrayAccess;
use Countable;
use IteratorAggregate;

interface IWidgetContextToIntervalMap extends ArrayAccess, Countable, IteratorAggregate
{
    public function offsetGet(mixed $offset): ?IInterval;
}
