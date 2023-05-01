<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

final class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected bool $loopAvailable,
        protected OptionAutoStart $optionAutoStart,
        protected bool $signalProcessingAvailable,
        protected OptionAttachHandlers $optionAttachHandlers,
    ) {
    }

    public function isLoopAvailable(): bool
    {
        return $this->loopAvailable;
    }

    public function isAutoStartEnabled(): bool
    {
        return $this->optionAutoStart === OptionAutoStart::ENABLED;
    }

    public function setOptionAutoStart(OptionAutoStart $optionAutoStart): ILoopSettings
    {
        $this->optionAutoStart = $optionAutoStart;
        return $this;
    }

    public function isAttachHandlersEnabled(): bool
    {
        return $this->optionAttachHandlers === OptionAttachHandlers::ENABLED;
    }

    public function setAttachHandlersOption(OptionAttachHandlers $optionAttachHandlers): ILoopSettings
    {
        $this->optionAttachHandlers = $optionAttachHandlers;
        return $this;
    }

    public function isSignalProcessingAvailable(): bool
    {
        return $this->signalProcessingAvailable;
    }
}
