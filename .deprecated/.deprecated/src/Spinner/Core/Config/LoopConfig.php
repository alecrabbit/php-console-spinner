<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;

final class LoopConfig implements ILoopConfig
{
    public function __construct(
        protected OptionRunMode $runMode,
        protected OptionAutoStart $autoStart,
        protected OptionSignalHandlers $signalHandlersOption,
    ) {
    }

    public function isAsynchronous(): bool
    {
        return $this->runMode === OptionRunMode::ASYNC;
    }

    public function isEnabledAutoStart(): bool
    {
        return $this->autoStart === OptionAutoStart::ENABLED;
    }

    public function areEnabledSignalHandlers(): bool
    {
        return $this->signalHandlersOption === OptionSignalHandlers::ENABLED;
    }
}