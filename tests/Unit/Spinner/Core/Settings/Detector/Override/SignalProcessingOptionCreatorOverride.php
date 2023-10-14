<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlersOptionCreator;

class SignalProcessingOptionCreatorOverride implements ISignalHandlersOptionCreator
{
    public static function create(): SignalHandlersOption
    {
        return SignalHandlersOption::ENABLED;
    }
}
