<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Contract\Option\OptionRunMode;

interface ILoopSettings
{
    public function getRunModeOption(): OptionRunMode;

    public function setRunModeOption(OptionRunMode $runModeOption): ILoopSettings;

    public function getAutoStartOption(): OptionAutoStart;

    public function setAutoStartOption(OptionAutoStart $autoStartOption): ILoopSettings;

    public function getSignalHandlersOption(): OptionAttachHandlers;

    public function setAttachHandlersOption(OptionAttachHandlers $signalHandlersOption): ILoopSettings;
}
