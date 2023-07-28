<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;

interface ILoopConfig
{
    public function getSignalHandlersMode(): SignalHandlersMode;

    public function getAutoStartMode(): AutoStartMode;
}
