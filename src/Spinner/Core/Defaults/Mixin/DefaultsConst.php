<?php

declare(strict_types=1);
// 14.02.23
namespace AlecRabbit\Spinner\Core\Defaults\Mixin;

use AlecRabbit\Spinner\Contract\ColorMode;

trait DefaultsConst
{
    final protected const SHUTDOWN_DELAY = 0.15;
    final protected const SHUTDOWN_MAX_DELAY = 10;
    final protected const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;
    final protected const MESSAGE_ON_INTERRUPT = PHP_EOL . 'Interrupted!' . PHP_EOL;
    final protected const MESSAGE_ON_FINALIZE = PHP_EOL;
    final protected const TERMINAL_COLOR_SUPPORT_MODES = [ColorMode::ANSI24, ColorMode::ANSI8, ColorMode::ANSI4, ColorMode::NONE];
    final protected const TERMINAL_HIDE_CURSOR = true;
    final protected const SPINNER_MODE_IS_SYNCHRONOUS = false;
    final protected const SPINNER_CREATE_INITIALIZED = false;
    final protected const AUTO_START = true;
    final protected const ATTACH_SIGNAL_HANDLERS = true;
    final protected const INTERVAL_MS = 1000;
    final protected const PERCENT_NUMBER_FORMAT = "%' 3.0f%%";
}
