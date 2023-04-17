<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

/** @psalm-suppress UnusedClass */
final class Ascii extends AReversiblePattern
{
    protected const UPDATE_INTERVAL = 300;
    protected const PATTERN = ['/', '|', '\\', '─',];
}
