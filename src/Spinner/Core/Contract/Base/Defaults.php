<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Base;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

final class Defaults
{
    public const SHUTDOWN_DELAY = 0.15;
    public const MAX_SHUTDOWN_DELAY = 10;
    public const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)';
    public const SPINNER_FRAME_INTERVAL = 0.1;
    public const ERASE_WIDTH = 1;
    public const FRAME_SEQUENCE = FramePattern::SNAKE_VARIANT_0;
    public const MAX_WIDTH = 100;
    public const MILLISECONDS_INTERVAL = 100;
    public const SECONDS_INTERVAL = 100 / 1000;
    public const COLOR_SUPPORT_LEVELS =  ALLOWED_TERM_COLOR;
    public const MILLISECONDS_MAX_INTERVAL = 1000000;

    private function __construct()
    {
    }
}
