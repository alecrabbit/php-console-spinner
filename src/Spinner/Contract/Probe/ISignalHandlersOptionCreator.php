<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;

interface ISignalHandlersOptionCreator extends ICreator
{
    public static function create(): SignalHandlersOption;
}
