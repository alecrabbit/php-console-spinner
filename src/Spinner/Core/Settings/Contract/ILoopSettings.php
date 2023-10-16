<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;

interface ILoopSettings extends ISettingsElement
{
    public function getAutoStartOption(): AutoStartOption;

    public function setSignalHandlingOption(SignalHandlingOption $signalHandlersOption): void;

    public function getSignalHandlingOption(): SignalHandlingOption;

    public function setAutoStartOption(AutoStartOption $autoStartOption): void;
}
