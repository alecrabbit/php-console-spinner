<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class BlueRed extends AStylePattern
{
    protected const UPDATE_INTERVAL = 800;

    protected const PATTERN = [63, 99, 135, 171, 207, 206, 205, 204, 205, 206, 207, 171, 135, 99,];
}
