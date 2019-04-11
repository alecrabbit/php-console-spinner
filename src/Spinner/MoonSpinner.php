<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Styling;

class MoonSpinner extends Spinner
{
    protected const ERASING_SHIFT = 2;
    protected const SYMBOLS = SpinnerSymbols::MOON;
    protected const
        STYLES =
        [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::DISABLED,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::DISABLED,
        ];
}
