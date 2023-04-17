<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

/** @psalm-suppress UnusedClass */
final class Speaker extends APattern
{
    protected const UPDATE_INTERVAL = 300;

    protected const PATTERN = [
        "🔈 ",
        "🔉 ",
        "🔊 ",
        "🔉 "
    ];
}
