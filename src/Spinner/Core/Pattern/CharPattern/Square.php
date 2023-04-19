<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\ALegacyReversiblePattern;
use ArrayObject;
use Traversable;

/** @psalm-suppress UnusedClass */
final class Square extends ALegacyReversiblePattern
{
    protected const INTERVAL = 120;

    protected const PATTERN = [
        '◼    ',
        ' ◼   ',
        '  ◼  ',
        '   ◼ ',
        '    ◼',
        '   ◼ ',
        '  ◼  ',
        ' ◼   ',
    ];

    protected function entries(): Traversable
    {
        return new ArrayObject(self::PATTERN);
    }
}
