<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface IWeakMap extends ArrayAccess, Countable, IteratorAggregate
{

}
