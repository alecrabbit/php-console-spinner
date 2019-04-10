<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class MoonSpinner extends AbstractSpinner
{
    protected const ERASING_SHIFT = 2;

    /** {@inheritDoc} */
    protected function getSymbols(): array
    {
        return [
            '🌘',
            '🌗',
            '🌖',
            '🌕',
            '🌔',
            '🌓',
            '🌒',
            '🌑',
// Reversed
//            '🌑',
//            '🌒',
//            '🌓',
//            '🌔',
//            '🌕',
//            '🌖',
//            '🌗',
//            '🌘',
        ];
    }

    /** {@inheritDoc} */
    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::DISABLED,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::DISABLED,
        ];
    }
}
