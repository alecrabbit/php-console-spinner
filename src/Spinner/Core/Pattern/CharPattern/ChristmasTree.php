<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

/** @psalm-suppress UnusedClass */
final class ChristmasTree extends APattern
{
    protected const INTERVAL = 500;

    protected const PATTERN = ['🌲', '🎄'];

    protected function entries(): \Traversable
    {
        return new \ArrayObject(self::PATTERN);
    }
}
