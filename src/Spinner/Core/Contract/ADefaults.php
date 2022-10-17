<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

abstract class ADefaults
{
    final protected const SHUTDOWN_DELAY = 0.15;
    final protected const MAX_SHUTDOWN_DELAY = 10;
    final protected const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;
    final protected const MESSAGE_INTERRUPTED = 'Interrupted!' . PHP_EOL;
    final protected const FINAL_MESSAGE = PHP_EOL;
    final protected const MAX_WIDTH = 100;
    final protected const MILLISECONDS_INTERVAL = 1000;
    final protected const COLOR_SUPPORT_LEVELS = ALLOWED_TERM_COLOR;
    final protected const MILLISECONDS_MIN_INTERVAL = 0;
    final protected const MILLISECONDS_MAX_INTERVAL = 1000000;
    final protected const HIDE_CURSOR = true;
    final protected const MODE_IS_SYNCHRONOUS = false;
    final protected const PROGRESS_FORMAT = '%0.1f%%';

    protected function __construct()
    {
    }

}
