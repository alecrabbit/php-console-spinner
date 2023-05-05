<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;

interface ILoopSettings
{
    public function isAutoStartEnabled(): bool;

    public function setOptionAutoStart(OptionAutoStart $optionAutoStart): ILoopSettings;

    public function isAttachHandlersEnabled(): bool;

    public function setAttachHandlersOption(OptionAttachHandlers $optionAttachHandlers): ILoopSettings;

    public function isLoopAvailable(): bool;

    public function isSignalProcessingAvailable(): bool;
}