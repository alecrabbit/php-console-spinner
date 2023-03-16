<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

final class FistBump extends AReversiblePattern
{
    protected const UPDATE_INTERVAL = 80;

    protected function pattern(): iterable
    {
        return [
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
    }
}
