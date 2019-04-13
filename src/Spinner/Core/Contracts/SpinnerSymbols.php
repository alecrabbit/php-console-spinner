<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contracts;

/**
 *      ***ATTENTION!***
 *
 * If you can't see any symbols doesn't mean they're not there!
 * They ARE!
 */
interface SpinnerSymbols
{
    public const BASE = [];

    public const DIAMOND = ['♦'];

    public const SIMPLE = ['/', '|', '\\', '─',];

    public const CIRCLES = ['◐', '◓', '◑', '◒',];
    public const SECTORS = ['◴', '◷', '◶', '◵'];

    public const CLOCK = ['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',];
    public const CLOCK_VARIANT = ['🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦',];

    public const MOON = ['🌘', '🌗', '🌖', '🌕', '🌔', '🌓', '🌒', '🌑',];
    public const MOON_REVERSED = ['🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘',];

    public const DOT = ['⢀', '⡀', '⠄', '⠂', '⠁', '⠈', '⠐', '⠠',];
    public const DOT_REVERSED = ['⠠', '⠐', '⠈', '⠁', '⠂', '⠄', '⡀', '⢀',];

    public const SNAKE_VARIANT_0 = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇',];
    public const SNAKE_VARIANT_1 = ['⣇', '⡏', '⠟', '⠻', '⢹', '⣸', '⣴', '⣦',];
    public const SNAKE_VARIANT_2 = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];

    public const DICE = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅',];

    public const
        ZODIAC =
        [
            '♈', // ARIES
            '♉', // TAURUS
            '♊', // GEMINI
            '♋', // CANCER
            '♌', // LEO
            '♍', // VIRGO
            '♎', // LIBRA
            '♏', // SCORPIUS
            '♐', // SAGITTARIUS
            '♑', // CAPRICORN
            '♒', // AQUARIUS
            '♓', // PISCES
        ];

    public const ARROWS = ['➙', '➘', '➙', '➚',];

    public const
        FEATHERED_ARROWS =
        [
            '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
            '➴', // BLACK-FEATHERED SOUTH EAST ARROW
            '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
            '➶', // BLACK-FEATHERED NORTH EAST ARROW
            '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
            '➷', // HEAVY BLACK-FEATHERED SOUTH EAST ARROW
            '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
            '➹', // HEAVY BLACK-FEATHERED NORTH EAST ARROW
        ];
}
