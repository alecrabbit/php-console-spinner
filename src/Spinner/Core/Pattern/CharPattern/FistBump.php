<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use ArrayObject;
use Traversable;

/** @psalm-suppress UnusedClass */
final class FistBump extends AReversiblePattern
{
    protected const INTERVAL = 80;

    protected const PATTERN = [
        "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
        "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
        "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
        "\u{3000}🤜\u{3000}\u{3000}🤛\u{3000}\u{3000} ",
        "\u{3000}\u{3000}🤜🤛\u{3000}\u{3000}\u{3000} ",
        "\u{3000}\u{3000}🤜✨🤛\u{3000}\u{3000} ",
        "\u{3000}🤜\u{3000}\u{3000}🤛\u{3000}\u{3000} ",
        "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
        "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
        "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
    ];

    protected function entries(): Traversable
    {
        return new ArrayObject(self::PATTERN);
    }
}
