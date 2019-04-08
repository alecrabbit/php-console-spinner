<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class MoonSpinner extends AbstractSpinner
{
    protected const ERASING_SHIFT = 2;

    /** {@inheritDoc} */
    protected function getSymbols(): Circular
    {
        return new Circular([
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
        ]);
    }

    /** {@inheritDoc} */
    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => null,
            Styling::COLOR_SPINNER_STYLES => null,
        ];
    }
}
