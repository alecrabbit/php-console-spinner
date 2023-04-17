<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

/** @psalm-suppress UnusedClass */
final class Mindblown extends APattern
{
    private const SPACE = "\u{3000} ";

    protected const UPDATE_INTERVAL = 200;

    protected const PATTERN = [
        '😊 ',
        '🙂 ',
        '😐 ',
        '😐 ',
        '😮 ',
        '😮 ',
        '😦 ',
        '😦 ',
        '😧 ',
        '😧 ',
        '🤯 ',
        '💥 ',
        '✨ ',
        self::SPACE,
        self::SPACE,
        self::SPACE
    ];
}
