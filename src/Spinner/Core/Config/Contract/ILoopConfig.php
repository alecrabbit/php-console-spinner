<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\RunMode;

interface ILoopConfig
{
    public function isAutoStartEnabled(): bool;

    public function areSignalHandlersEnabled(): bool;

    public function isAsynchronous(): bool;

    public function getSignalHandlers(): ?iterable;
}