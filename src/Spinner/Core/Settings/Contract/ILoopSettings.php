<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;

interface ILoopSettings
{
    public function getAutoStartOption(): AutoStartOption;

    public function setSignalHandlersOption(SignalHandlersOption $signalHandlersOption): void;

    public function getSignalHandlersOption(): SignalHandlersOption;

    public function setAutoStartOption(AutoStartOption $autoStartOption): void;
}
