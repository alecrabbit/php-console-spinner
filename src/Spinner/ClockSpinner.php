<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class ClockSpinner extends AbstractSpinner
{
    /**
     * @return Circular
     */
    protected function getSymbols(): Circular
    {
        return new Circular([
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
