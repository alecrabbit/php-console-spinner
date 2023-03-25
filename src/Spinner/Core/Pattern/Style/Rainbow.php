<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class Rainbow extends AStylePattern
{
    protected const UPDATE_INTERVAL = 400;

    protected const PATTERN = [
        196, // 196
        '#ff0000', // 196
        '#ff8700', // 208
        '#ffaf00', // 214
        '#ffd700', // 220
        '#ffff00', // 226
        '#d7ff00', // 190
        '#afff00', // 154
        '#87ff00', // 118
        '#5fff00', // 82
        '#00ff00', // 46
        '#00ff5f', // 47
        '#00ff87', // 48
        '#00ffaf', // 49
        '#00ffd7', // 50
        '#00ffff', // 51
        '#00d7ff', // 45
        '#00afff', // 39
        '#0087ff', // 33
        '#005fff', // 27
        '#5f00d7', // 56
        '#5f00ff', // 57
        '#8700ff', // 93
        '#af00ff', // 129
        '#d700ff', // 165
        '#ff00ff', // 201
        '#ff00d7', // 200
        '#ff00af', // 199
        '#ff0087', // 198
        '#ff005f', // 197

    ];
}
