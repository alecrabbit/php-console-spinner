<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Contract\SignalHandlers;

interface ILoopSettings extends IDefaultsChild
{
    public static function getInstance(
        IDefaults $parent,
    ): ILoopSettings;

    public function getAutoStartOption(): AutoStart;

    public function getSignalHandlersOption(): SignalHandlers;

    public function setSignalHandlersOption(SignalHandlers $signalHandlersOption): ILoopSettings;

    public function setAutoStartOption(AutoStart $autoStartOption): ILoopSettings;
}
