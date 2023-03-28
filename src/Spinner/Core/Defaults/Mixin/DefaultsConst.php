<?php

declare(strict_types=1);
// 14.02.23

namespace AlecRabbit\Spinner\Core\Defaults\Mixin;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;

trait DefaultsConst
{
    /** @var OptionSignalHandlers */
    final protected const SIGNAL_HANDLERS_OPTION = OptionSignalHandlers::ENABLED;
    /** @var OptionAutoStart */
    final protected const AUTO_START_OPTION = OptionAutoStart::ENABLED;
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
    /** @var OptionRunMode */
    final protected const RUN_MODE = OptionRunMode::ASYNC;
    /** @var float */
    final protected const SHUTDOWN_DELAY = 0.15;
    /** @var int */
    final protected const SHUTDOWN_MAX_DELAY = 10;
    /** @var OptionInitialization */
    final protected const INITIALIZATION_OPTION = OptionInitialization::ENABLED;
}
