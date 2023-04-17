<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

/** @psalm-suppress UnusedClass */
final class ShortSnake extends AReversiblePattern
{
    protected const INTERVAL = 80;

    protected const PATTERN = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];

    protected function entries(): \Traversable
    {
        return new \ArrayObject(self::PATTERN);
    }
}
