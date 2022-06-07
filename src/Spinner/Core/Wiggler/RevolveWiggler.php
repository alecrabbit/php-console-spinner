<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class RevolveWiggler extends AWiggler implements IRevolveWiggler
{
    protected function getSequence(float|int|null $interval = null): string
    {
        return
            $this->styleRotor->join(
                chars: $this->charRotor->next($interval),
                interval: $interval,
            );
    }
}
