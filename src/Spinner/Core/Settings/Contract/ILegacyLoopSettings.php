<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\AutoStartOption;

interface ILegacyLoopSettings
{
    public function isAutoStartEnabled(): bool;

    public function setOptionAutoStart(AutoStartOption $optionAutoStart): ILegacyLoopSettings;

    public function isAttachHandlersEnabled(): bool;

    public function setAttachHandlersOption(SignalHandlersOption $optionAttachHandlers): ILegacyLoopSettings;

    public function isLoopAvailable(): bool;

    public function isSignalProcessingAvailable(): bool;
}
