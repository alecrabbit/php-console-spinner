<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

/** @psalm-suppress UnusedClass */
final class Mindblown extends APattern
{
    protected const UPDATE_INTERVAL = 200;

    protected const PATTERN = [
        "😊 ",
        "🙂 ",
        "😐 ",
        "😐 ",
        "😮 ",
        "😮 ",
        "😦 ",
        "😦 ",
        "😧 ",
        "😧 ",
        "🤯 ",
        "💥 ",
        "✨ ",
        "\u{3000} ",
        "\u{3000} ",
        "\u{3000} "
    ];
}