<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Rotor\Contract\AWIPStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class NoStyleRotor extends AWIPStyleRotor
{
    public function next(?IInterval $interval = null): string
    {
        return '';
    }
}
