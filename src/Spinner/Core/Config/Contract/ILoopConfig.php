<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersContainer;

interface ILoopConfig extends IConfigElement
{
    public function getSignalHandlingMode(): SignalHandlingMode;

    public function getAutoStartMode(): AutoStartMode;

    public function getSignalHandlersContainer(): ISignalHandlersContainer;
}
