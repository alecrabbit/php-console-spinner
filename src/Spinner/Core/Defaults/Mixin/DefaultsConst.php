<?php

declare(strict_types=1);
// 14.02.23

namespace AlecRabbit\Spinner\Core\Defaults\Mixin;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\RunMode;

trait DefaultsConst
{
    /** @var bool */
    final protected const ATTACH_SIGNAL_HANDLERS = true;
    /** @var bool */
    final protected const AUTO_START = true;
    /** @var int */
    final protected const INTERVAL_MS = 1000;
    /** @var string */
    final protected const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;
    /** @var string */
    final protected const MESSAGE_ON_FINALIZE = PHP_EOL;
    /** @var string */
    final protected const MESSAGE_ON_INTERRUPT = PHP_EOL . 'Interrupted!' . PHP_EOL;
    /** @var string */
    final protected const PERCENT_NUMBER_FORMAT = "%' 3.0f%%";
    /** @var RunMode */
    final protected const RUN_MODE = RunMode::ASYNC;
    /** @var float */
    final protected const SHUTDOWN_DELAY = 0.15;
    /** @var int */
    final protected const SHUTDOWN_MAX_DELAY = 10;
    /** @var bool */
    final protected const SPINNER_CREATE_INITIALIZED = false;
    /** @var bool */
    final protected const SPINNER_MODE_IS_SYNCHRONOUS = false;
    /** @var bool */
    final protected const TERMINAL_HIDE_CURSOR = true;
    /** @var array<ColorMode> */
    final protected const TERMINAL_COLOR_SUPPORT_MODES = [
        ColorMode::ANSI24,
        ColorMode::ANSI8,
        ColorMode::ANSI4,
        ColorMode::NONE
    ];
}
