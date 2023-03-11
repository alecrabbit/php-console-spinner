<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

final class Clock extends AReversiblePattern
{
    protected const UPDATE_INTERVAL = 300;

    protected function pattern(): iterable
    {
        return [
            '🕐',
            '🕜',
            '🕑',
            '🕝',
            '🕒',
            '🕞',
            '🕓',
            '🕟',
            '🕔',
            '🕠',
            '🕕',
            '🕡',
            '🕖',
            '🕢',
            '🕗',
            '🕣',
            '🕘',
            '🕤',
            '🕙',
            '🕥',
            '🕚',
            '🕦',
            '🕛',
            '🕧',
        ];
    }
}