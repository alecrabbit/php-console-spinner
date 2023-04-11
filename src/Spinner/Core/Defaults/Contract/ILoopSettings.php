<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Contract\Option\OptionRunMode;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;

interface ILoopSettings
{
    public function isAutoStartEnabled(): bool;

    public function setOptionAutoStart(OptionAutoStart $optionAutoStart): ILoopSettings;

    public function isAttachHandlersEnabled(): bool;

    public function setAttachHandlersOption(OptionAttachHandlers $optionAttachHandlers): ILoopSettings;

    public function isLoopAvailable(): bool;
}
