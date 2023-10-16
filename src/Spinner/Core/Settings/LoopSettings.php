<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

final class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected AutoStartOption $autoStartOption = AutoStartOption::AUTO,
        protected SignalHandlingOption $signalHandlersOption = SignalHandlingOption::AUTO,
    ) {
    }

    public function getAutoStartOption(): AutoStartOption
    {
        return $this->autoStartOption;
    }

    public function setAutoStartOption(AutoStartOption $autoStartOption): void
    {
        $this->autoStartOption = $autoStartOption;
    }

    public function getSignalHandlingOption(): SignalHandlingOption
    {
        return $this->signalHandlersOption;
    }

    public function setSignalHandlingOption(SignalHandlingOption $signalHandlersOption): void
    {
        $this->signalHandlersOption = $signalHandlersOption;
    }

    public function getIdentifier(): string
    {
        return ILoopSettings::class;
    }
}
