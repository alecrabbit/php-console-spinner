<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\LoopAutoStartOption;

interface ILoopSettings
{
    public function isAutoStartEnabled(): bool;

    public function setOptionAutoStart(LoopAutoStartOption $optionAutoStart): ILoopSettings;

    public function isAttachHandlersEnabled(): bool;

    public function setAttachHandlersOption(SignalHandlersOption $optionAttachHandlers): ILoopSettings;

    public function isLoopAvailable(): bool;

    public function isSignalProcessingAvailable(): bool;
}
