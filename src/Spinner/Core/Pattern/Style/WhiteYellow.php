<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class WhiteYellow extends AStylePattern
{
    protected const UPDATE_INTERVAL = 800;

    protected const PATTERN = [
        226,
        227,
        228,
        229,
        230,
        231,
        231,
        230,
        229,
        228,
        227,
        226,
    ];
}
