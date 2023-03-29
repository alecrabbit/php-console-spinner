<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use Traversable;

abstract class ALoopConfig implements ILoopConfig
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

    public function isAutoStartEnabled(): bool
    {
        return $this->autoStart === OptionAutoStart::ENABLED;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return $this->signalHandlersOption === OptionSignalHandlers::ENABLED;
    }

    public function getSignalHandlers(): ?Traversable
    {
        // TODO: Implement getSignalHandlers() method?
        return null;
    }
}