<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlersOptionCreator;

final class SignalHandlersOptionCreator implements ISignalHandlersOptionCreator
{
    public static function create(): SignalHandlersOption
    {
        // FIXME (2023-10-10 16:53) [Alec Rabbit]: It is a stub!
        return SignalHandlersOption::ENABLED;
    }
}
