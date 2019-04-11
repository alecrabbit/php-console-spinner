<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Spinner;

class SnakeSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = SpinnerSymbols::SNAKE;
    protected const
        STYLES =
        [
            Contracts\StylesInterface::COLOR256_SPINNER_STYLES => SpinnerStyles::C256_RAINBOW,
            Contracts\StylesInterface::COLOR_SPINNER_STYLES => SpinnerStyles::C_LIGHT_CYAN,
        ];
}
