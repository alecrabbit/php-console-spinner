<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

final class Mindblown extends APattern
{
    protected const UPDATE_INTERVAL = 200;

    public function getPattern(): iterable
    {
        return [
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
}