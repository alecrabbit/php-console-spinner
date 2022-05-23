<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class RevolveWiggler extends AWiggler implements IRevolveWiggler
{
    protected function getSequence(float|int|null $interval = null): string
    {
        $fg = $this->colorRotor->next();
        $char = $this->charRotor->next();
        return "38;5;{$fg}m{$char}";
    }
}
