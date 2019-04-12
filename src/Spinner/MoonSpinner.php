<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class MoonSpinner extends Spinner
{
    protected const ERASING_SHIFT = 2;
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = SpinnerSymbols::MOON;
    protected const
        STYLES =
        [
            StylesInterface::COLOR256_SPINNER_STYLES => StylesInterface::DISABLED,
            StylesInterface::COLOR_SPINNER_STYLES => StylesInterface::DISABLED,
            StylesInterface::COLOR_MESSAGE_STYLES => StylesInterface::C_DARK,
            StylesInterface::COLOR_PERCENT_STYLES => StylesInterface::C_DARK,
        ];
}
