<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Contracts;

interface SettingsInterface
{
    public const MAX_SYMBOLS_COUNT = 50;

    public const DEFAULT_SUFFIX = '...';
    public const ONE_SPACE_SYMBOL = ' ';
    public const EMPTY = '';

    public const DEFAULT_INTERVAL = 0.1;
    public const DEFAULT_ERASING_SHIFT = 1;
    public const DEFAULT_SYMBOLS = SpinnerSymbols::BASE;
    public const
        DEFAULT_STYLES =
        [
            StylesInterface::COLOR256_SPINNER_STYLES => StylesInterface::DISABLED,
            StylesInterface::COLOR_SPINNER_STYLES => StylesInterface::DISABLED,
            StylesInterface::COLOR_MESSAGE_STYLES => StylesInterface::DISABLED,
            StylesInterface::COLOR_PERCENT_STYLES => StylesInterface::DISABLED,
        ];
}
