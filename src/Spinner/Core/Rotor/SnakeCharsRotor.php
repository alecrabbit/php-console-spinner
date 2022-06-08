<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Rotor\Contract\AStringRotor;

final class SnakeCharsRotor extends AStringRotor
{
    protected const DATA = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    protected const ELEMENT_WIDTH = 1;
}
