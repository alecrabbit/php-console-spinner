<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\RunMode;

abstract class ALoopConfig implements ILoopConfig
{
    public function __construct(
        protected RunMode $runMode,
        protected bool $autoStart,
        protected bool $attachSignalHandlers,
    ) {
    }

    public function isAsynchronous(): bool
    {
        return $this->runMode === RunMode::ASYNC;
    }

    public function getRunMode(): RunMode
    {
        return $this->runMode;
    }

    public function isAutoStartEnabled(): bool
    {
        return $this->autoStart;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return $this->attachSignalHandlers;
    }

    public function getSignalHandlers(): ?iterable
    {
        // TODO: Implement getSignalHandlers() method?
        return null;
    }
}