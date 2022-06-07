<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class SnakeCharRotor extends ACharRotor
{
    protected const DATA = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    protected const ELEMENT_WIDTH = 1;
}
