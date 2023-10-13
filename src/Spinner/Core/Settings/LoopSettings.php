<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

final class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected AutoStartOption $autoStartOption = AutoStartOption::AUTO,
        protected SignalHandlersOption $signalHandlersOption = SignalHandlersOption::AUTO,
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

    public function getSignalHandlersOption(): SignalHandlersOption
    {
        return $this->signalHandlersOption;
    }

    public function setSignalHandlersOption(SignalHandlersOption $signalHandlersOption): void
    {
        $this->signalHandlersOption = $signalHandlersOption;
    }

    public function getIdentifier(): string
    {
        return ILoopSettings::class;
    }
}
