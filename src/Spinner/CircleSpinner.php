<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class CircleSpinner extends AbstractSpinner
{
    protected const INTERVAL = 0.17;
    protected const SYMBOLS = SpinnerSymbols::CIRCLES;

    /** {@inheritDoc} */
    protected function getSymbols(): array
    {
        return [
            '◐',
            '◓',
            '◑',
            '◒',
        ];
    }

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::C256_YELLOW_WHITE,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::C_LIGHT_YELLOW,
        ];
    }
}
