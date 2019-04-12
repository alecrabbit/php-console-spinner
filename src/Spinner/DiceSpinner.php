<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class DiceSpinner extends Spinner
{
    protected const ERASING_SHIFT =  1;
    protected const INTERVAL = 0.17;
    protected const SYMBOLS = SpinnerSymbols::DICE;
    protected const
        STYLES =
        [
            StylesInterface::COLOR256_SPINNER_STYLES => StylesInterface::C256_RAINBOW,
            StylesInterface::COLOR_SPINNER_STYLES => StylesInterface::C_LIGHT_CYAN,
            StylesInterface::COLOR_MESSAGE_STYLES => StylesInterface::C_DARK,
            StylesInterface::COLOR_PERCENT_STYLES => StylesInterface::C_DARK,
        ];
}
