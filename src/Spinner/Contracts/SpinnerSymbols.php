<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Contracts;

interface SpinnerSymbols
{
    public const CIRCLES = ['◐', '◓', '◑', '◒',];

    // If you can't see clock symbols doesn't mean they're not there!
    // They ARE!
    public const CLOCK = ['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',];
    // If you can't see clock symbols doesn't mean they're not there!
    // They ARE!
    public const CLOCK_VARIANT = ['🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦',];

    public const MOON = ['🌘', '🌗', '🌖', '🌕', '🌔', '🌓', '🌒', '🌑',];
    public const MOON_REVERSED = ['🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘',];

    public const SIMPLE = ['/', '|', '\\', '─',];

    public const SNAKE = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];
}
