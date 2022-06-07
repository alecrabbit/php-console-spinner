<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharsRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class SnakeCharsRotor extends ACharsRotor
{
    protected const DATA = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    protected const ELEMENT_WIDTH = 1;
}
