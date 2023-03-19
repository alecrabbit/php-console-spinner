<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Contract\SignalHandlers;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\RunMode;

abstract class ALoopConfig implements ILoopConfig
{
    public function __construct(
        protected RunMode $runMode,
        protected AutoStart $autoStart,
        protected SignalHandlers $signalHandlersOption,
    ) {
    }

    public function isAsynchronous(): bool
    {
        return $this->runMode === RunMode::ASYNC;
    }

    public function isAutoStartEnabled(): bool
    {
        return $this->autoStart === AutoStart::ENABLED;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return $this->signalHandlersOption === SignalHandlers::ENABLED;
    }

    public function getSignalHandlers(): ?iterable
    {
        // TODO: Implement getSignalHandlers() method?
        return null;
    }
}