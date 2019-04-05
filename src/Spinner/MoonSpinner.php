<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

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
    protected function getStyles(): ?Circular
    {
        return null;
    }
}
