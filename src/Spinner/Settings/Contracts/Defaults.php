<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings\Contracts;

use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;

interface Defaults
{
    public const ONE_SPACE_SYMBOL = ' ';
    public const EMPTY_STRING = '';
    public const DEFAULT_SUFFIX = self::DOTS_SUFFIX;
    public const DOTS_SUFFIX = '...';
    public const ELLIPSIS = '…';

    public const MAX_FRAMES_COUNT = 256;
    public const MAX_FRAME_WIDTH = 10;

    public const DEFAULT_INTERVAL = 0.1;
    public const DEFAULT_FRAMES = [];
    public const DEFAULT_FORMAT = '%s';
    public const DEFAULT_SPACER = self::ONE_SPACE_SYMBOL;

    public const DEFAULT_SETTINGS =
        [
            S::INLINE_SPACER => self::ONE_SPACE_SYMBOL,
            S::INTERVAL => self::DEFAULT_INTERVAL,
            S::FRAMES => self::DEFAULT_FRAMES,
            S::ERASING_SHIFT => 0,
            S::MESSAGE => self::EMPTY_STRING,
            S::MESSAGE_ERASING_LENGTH => 0,
            S::MESSAGE_SUFFIX => self::DEFAULT_SUFFIX,
            S::STYLES => Styles::STYLING_DISABLED,
            S::SPACER => self::EMPTY_STRING,
            S::INITIAL_PERCENT => null,
            S::ENABLED => true,
            S::HIDE_CURSOR => true,
            S::JUGGLERS_ORDER => self::DEFAULT_ORDER_DIRECTIVES,
        ];
    public const NUMBER_OF_ORDER_DIRECTIVES = 3;
    public const DEFAULT_ORDER_DIRECTIVES = [Juggler::FRAMES, Juggler::MESSAGE, Juggler::PROGRESS];
    public const DIRECTIVES_NAMES = [
        Juggler::FRAMES => 'FRAMES',
        Juggler::MESSAGE => 'MESSAGE',
        Juggler::PROGRESS => 'PROGRESS',
    ];
}
