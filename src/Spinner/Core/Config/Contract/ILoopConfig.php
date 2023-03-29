<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use Traversable;

interface ILoopConfig
{
    public function isEnabledAutoStart(): bool;

    public function areEnabledSignalHandlers(): bool;

    public function isAsynchronous(): bool;
}