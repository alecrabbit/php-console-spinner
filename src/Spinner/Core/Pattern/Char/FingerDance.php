<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class FingerDance extends APattern
{
    protected const UPDATE_INTERVAL = 300;

    protected const PATTERN = [
            "🤘 ",
            "🤟 ",
            "🖖 ",
            "✋ ",
            "🤚 ",
            "👆 "
        ];
}
