<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\FrameHolder;

final class RevolveWiggler implements IRevolveWiggler
{
    public function __construct(
        private readonly Color $color,
        private readonly FrameHolder $frameHolder,
    ) {
    }
}
