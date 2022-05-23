<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\FrameHolder;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class RevolveWiggler extends AWiggler implements IRevolveWiggler
{
    public function __construct(
        private readonly Color $color,
        private readonly FrameHolder $frameHolder,
    ) {
    }

    public function getSequence(float|int|null $interval = null): string
    {
        $fg = $this->color->next();
        $char = $this->frameHolder->next();
        return "38;5;{$fg}m{$char}";
    }

    public function getWidth(): int
    {
        return 1;
    }

}
