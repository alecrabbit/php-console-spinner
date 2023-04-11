<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

final class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected bool $loopAvailable,
        protected OptionAutoStart $optionAutoStart,
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
}
