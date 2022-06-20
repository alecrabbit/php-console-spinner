<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Kernel\Contract\Base\FramePattern;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

abstract class ADefaults
{
    final public const SHUTDOWN_DELAY = 0.15;
    final public const MAX_SHUTDOWN_DELAY = 10;
    final public const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;
    final public const MESSAGE_INTERRUPTED = 'Interrupted!' . PHP_EOL;
    final public const FINAL_MESSAGE = PHP_EOL;
    final public const SPINNER_FRAME_INTERVAL = 0.1;
    final public const ERASE_WIDTH = 1;
    final public const FRAME_SEQUENCE = FramePattern::SNAKE_VARIANT_0;
    final public const MAX_WIDTH = 100;
    final public const MILLISECONDS_INTERVAL = 1000;
    final public const COLOR_SUPPORT_LEVELS = ALLOWED_TERM_COLOR;
    final public const MILLISECONDS_MIN_INTERVAL = 0;
    final public const MILLISECONDS_MAX_INTERVAL = 1000000;
    final public const HIDE_CURSOR = true;
    final public const SYNCHRONOUS_MODE = false;

    protected function __construct()
    {
    }

}
