<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Spinner;

class SnakeSpinner extends Spinner
{
    protected const SYMBOLS = SpinnerSymbols::SNAKE;
}
