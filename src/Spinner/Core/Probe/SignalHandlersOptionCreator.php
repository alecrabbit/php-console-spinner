<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlersOptionCreator;

final class SignalHandlersOptionCreator implements ISignalHandlersOptionCreator
{
    private const SIGNAL_PROCESSING_EXTENSION = 'pcntl';

    public static function create(): SignalHandlersOption
    {
        return
            extension_loaded(self::SIGNAL_PROCESSING_EXTENSION)
                ? SignalHandlersOption::ENABLED
                : SignalHandlersOption::DISABLED;
    }
}
