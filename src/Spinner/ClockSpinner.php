<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Styling;

class ClockSpinner extends Spinner
{
    protected const ERASING_SHIFT = 2;
    protected const SYMBOLS = SpinnerSymbols::CLOCK;

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::DISABLED,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::DISABLED,
        ];
    }
}
