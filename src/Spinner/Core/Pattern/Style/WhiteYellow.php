<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class WhiteYellow extends AStylePattern
{
    protected const UPDATE_INTERVAL = 800;

    protected const PATTERN = [
        '#ffff00', // 226
        '#ffff5f', // 227
        '#ffff87', // 228
        '#ffffaf', // 229
        '#ffffd7', // 230
        '#ffffff', // 231
        '#ffffff', // 231
        '#ffffd7', // 230
        '#ffffaf', // 229
        '#ffff87', // 228
        '#ffff5f', // 227
        '#ffff00', // 226
    ];
}
