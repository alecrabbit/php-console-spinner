<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Rotor\Contract\AStyleRotor;

final class NoStyleRotor extends AStyleRotor
{
    public function next(float|int|null $interval = null): string
    {
        return '';
    }
}
