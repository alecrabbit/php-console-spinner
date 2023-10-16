<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlersOptionCreator;

final class SignalHandlersOptionCreator implements ISignalHandlersOptionCreator
{
    private const SIGNAL_PROCESSING_EXTENSION = 'pcntl';

    public function create(): SignalHandlingOption
    {
        return
            extension_loaded(self::SIGNAL_PROCESSING_EXTENSION)
                ? SignalHandlingOption::ENABLED
                : SignalHandlingOption::DISABLED;
    }
}
