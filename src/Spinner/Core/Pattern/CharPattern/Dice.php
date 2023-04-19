<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\ALegacyReversiblePattern;
use ArrayObject;
use Traversable;

/** @psalm-suppress UnusedClass */
final class Dice extends ALegacyReversiblePattern
{
    protected const INTERVAL = 120;

    protected function entries(): Traversable
    {
        return new ArrayObject(['⚀', '⚁', '⚂', '⚃', '⚄', '⚅']);
    }
}
