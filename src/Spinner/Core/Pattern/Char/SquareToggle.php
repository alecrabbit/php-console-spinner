<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

/** @psalm-suppress UnusedClass */
final class SquareToggle extends AReversiblePattern
{
    protected const UPDATE_INTERVAL = 200;

    protected const PATTERN = [
        '■',
        '□',
        '▪',
        '▫',
    ];
}
