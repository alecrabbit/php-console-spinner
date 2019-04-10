<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Styling;

class CircleSpinner extends Spinner
{
    protected const INTERVAL = 0.17;
    protected const SYMBOLS = SpinnerSymbols::CIRCLES;

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::C256_YELLOW_WHITE,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::C_LIGHT_YELLOW,
        ];
    }
}
