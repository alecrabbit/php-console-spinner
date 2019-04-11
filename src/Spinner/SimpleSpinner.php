<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class SimpleSpinner extends Spinner
{
    protected const ERASING_SHIFT =  1;
    protected const INTERVAL = 0.17;
    protected const SYMBOLS = SpinnerSymbols::SIMPLE;
    protected const
        STYLES =
        [
            StylesInterface::COLOR256_SPINNER_STYLES => SpinnerStyles::C256_RAINBOW,
            StylesInterface::COLOR_SPINNER_STYLES => SpinnerStyles::C_LIGHT_CYAN,
            StylesInterface::COLOR_MESSAGE_STYLES => SpinnerStyles::C_DARK,
            StylesInterface::COLOR_PERCENT_STYLES => SpinnerStyles::C_DARK,
        ];
}
