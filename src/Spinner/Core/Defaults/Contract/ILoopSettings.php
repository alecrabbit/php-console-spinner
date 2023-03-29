<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;

interface ILoopSettings extends IDefaultsChild
{
    public static function getInstance(
        IDefaults $parent,
    ): ILoopSettings;

    public function getAutoStartOption(): OptionAutoStart;

    public function getSignalHandlersOption(): OptionSignalHandlers;

    public function overrideSignalHandlersOption(OptionSignalHandlers $signalHandlersOption): ILoopSettings;

    public function overrideAutoStartOption(OptionAutoStart $autoStartOption): ILoopSettings;
}
