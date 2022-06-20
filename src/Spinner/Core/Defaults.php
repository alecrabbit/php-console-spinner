<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Kernel\Contract\Base\FramePattern;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;
use const PHP_EOL;

final class Defaults
{
    public const SHUTDOWN_DELAY = 0.15;
    public const MAX_SHUTDOWN_DELAY = 10;
    public const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;
    public const MESSAGE_INTERRUPTED = 'Interrupted!' . PHP_EOL;
    public const FINAL_MESSAGE = PHP_EOL;
    public const SPINNER_FRAME_INTERVAL = 0.1;
    public const ERASE_WIDTH = 1;
    public const FRAME_SEQUENCE = FramePattern::SNAKE_VARIANT_0;
    public const MAX_WIDTH = 100;
    public const MILLISECONDS_INTERVAL = 1000;
    public const COLOR_SUPPORT_LEVELS = ALLOWED_TERM_COLOR;
    public const MILLISECONDS_MIN_INTERVAL = 0;
    public const MILLISECONDS_MAX_INTERVAL = 1000000;
    public const HIDE_CURSOR = true;
    public const SYNCHRONOUS_MODE = false;

    private function __construct()
    {
    }
}
