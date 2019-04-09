<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class CircleSpinner extends AbstractSpinner
{
    protected const INTERVAL = 0.17;

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
            Styling::COLOR256_SPINNER_STYLES => [226, 227, 228, 229, 230, 231, 230, 229, 228, 227, 226],
            Styling::COLOR_SPINNER_STYLES => [Styles::LIGHT_YELLOW],
        ];
    }

}
