<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class MoonSpinner extends AbstractSpinner
{
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
