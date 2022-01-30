<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

final class Defaults
{
    public const SHUTDOWN_DELAY = 0.5;
    public const MAX_SHUTDOWN_DELAY = 10;
    public const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)';

    private function __construct()
    {
    }
}
