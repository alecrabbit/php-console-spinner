<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\LoopAutoStartOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

final class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected bool $loopAvailable,
        protected LoopAutoStartOption $optionAutoStart,
        protected bool $signalProcessingAvailable,
        protected SignalHandlersOption $optionAttachHandlers,
    ) {
    }

    public function isLoopAvailable(): bool
    {
        return $this->loopAvailable;
    }

    public function isAutoStartEnabled(): bool
    {
        return $this->optionAutoStart === LoopAutoStartOption::ENABLED;
    }

    public function setOptionAutoStart(LoopAutoStartOption $optionAutoStart): ILoopSettings
    {
        $this->optionAutoStart = $optionAutoStart;
        return $this;
    }

    public function isAttachHandlersEnabled(): bool
    {
        return $this->optionAttachHandlers === SignalHandlersOption::ENABLED;
    }

    public function setAttachHandlersOption(SignalHandlersOption $optionAttachHandlers): ILoopSettings
    {
        $this->optionAttachHandlers = $optionAttachHandlers;
        return $this;
    }

    public function isSignalProcessingAvailable(): bool
    {
        return $this->signalProcessingAvailable;
    }
}
