<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class ClockSpinner extends AbstractSpinner
{
    protected const ERASING_SHIFT = 2;

    /** {@inheritDoc} */
    protected function getSymbols(): array
    {
        return [
            // If you can't see clock symbols doesn't mean they're not there!
            // They ARE!
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
            // If you can't see clock symbols doesn't mean they're not there!
            // They ARE!
            // '🕜',
            // '🕝',
            // '🕞',
            // '🕟',
            // '🕠',
            // '🕡',
            // '🕢',
            // '🕣',
            // '🕤',
            // '🕥',
            // '🕦',
        ];
    }

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::DISABLED,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::DISABLED,
        ];
    }
}
