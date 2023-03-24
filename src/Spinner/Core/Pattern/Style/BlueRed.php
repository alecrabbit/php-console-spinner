<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class BlueRed extends AStylePattern
{
    protected const UPDATE_INTERVAL = 800;

    protected const PATTERN = [
        '#5f5fff', // 63
        '#875fff', // 99
        '#af5fff', // 135
        '#d75fff', // 171
        '#ff5fff', // 207
        '#ff5fd7', // 206
        '#ff5faf', // 205
        '#ff5f87', // 204
        '#ff5faf', // 205
        '#ff5fd7', // 206
        '#ff5fff', // 207
        '#d75fff', // 171
        '#af5fff', // 135
        '#875fff', // 99
    ];
}
