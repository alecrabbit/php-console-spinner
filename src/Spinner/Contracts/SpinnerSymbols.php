<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Contracts;

/**
 * If you can't see any symbols doesn't mean they're not there!
 * They ARE!
 */
interface SpinnerSymbols
{
    public const CIRCLES = ['◐', '◓', '◑', '◒',];

    public const CLOCK = ['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',];
    public const CLOCK_VARIANT = ['🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦',];

    public const MOON = ['🌘', '🌗', '🌖', '🌕', '🌔', '🌓', '🌒', '🌑',];
    public const MOON_REVERSED = ['🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘',];

    public const BASE = ['/', '|', '\\', '─',];

    public const SIMPLE = ['◴', '◷', '◶', '◵'];

    public const SNAKE = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];
}
