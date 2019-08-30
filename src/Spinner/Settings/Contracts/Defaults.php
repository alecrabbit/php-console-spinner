<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Settings\Contracts;

use AlecRabbit\Spinner\Core\Contracts\StylesInterface;

interface Defaults
{
    public const ONE_SPACE_SYMBOL = ' ';
    public const EMPTY_STRING = '';
    public const DEFAULT_PREFIX = self::EMPTY_STRING;
    public const DEFAULT_SUFFIX = self::EMPTY_STRING;
    public const DOTS_SUFFIX = '...';

    public const MAX_FRAMES_COUNT = 50;
    public const MAX_FRAME_LENGTH = 10;

    public const DEFAULT_INTERVAL = 0.1;
    public const DEFAULT_FRAMES = [];

    public const DEFAULT_SETTINGS =
        [
            S::INTERVAL => self::DEFAULT_INTERVAL,
            S::ERASING_SHIFT => 0,
            S::MESSAGE => self::EMPTY_STRING,
            S::MESSAGE_ERASING_LENGTH => 0,
            S::MESSAGE_PREFIX => self::ONE_SPACE_SYMBOL,
            S::MESSAGE_SUFFIX => self::EMPTY_STRING,
            S::INLINE_PADDING_STR => self::EMPTY_STRING,
            S::FRAMES => self::DEFAULT_FRAMES,
            S::STYLES => StylesInterface::STYLING_DISABLED,
            S::SPACER => self::EMPTY_STRING,
        ];
}
