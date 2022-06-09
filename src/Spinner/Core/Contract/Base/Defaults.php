<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Base;

final class Defaults
{
    public const SHUTDOWN_DELAY = 0.15;
    public const MAX_SHUTDOWN_DELAY = 10;
    public const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)';
    public const SPINNER_FRAME_INTERVAL = 0.1;
    public const ERASE_WIDTH = 1;

    private function __construct()
    {
    }
}
