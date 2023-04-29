<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

/** @psalm-suppress UnusedClass */
final class ChristmasTree extends APattern
{
    protected const UPDATE_INTERVAL = 500;

    protected const PATTERN = ['🌲', '🎄',];
}