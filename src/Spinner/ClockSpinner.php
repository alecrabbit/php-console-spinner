<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class ClockSpinner extends AbstractSpinner
{
    protected const ERASING_SHIFT = 2;

    /**
     * @return Circular
     */
    protected function getSymbols(): Circular
    {
        return new Circular([
            // If you can't see clock symbols doesn't mean they're not there!
            '🕐',
            '🕑',
            '🕒',
            '🕓',
            '🕔',
            '🕕',
            '🕖',
            '🕗',
            '🕘',
            '🕙',
            '🕚',
            '🕛',
//            '🕜',
//            '🕝',
//            '🕞',
//            '🕟',
//            '🕠',
//            '🕡',
//            '🕢',
//            '🕣',
//            '🕤',
//            '🕥',
//            '🕦',
        ]);
    }

    protected function getStyles(): ?Circular
    {
        return null;
    }
}
