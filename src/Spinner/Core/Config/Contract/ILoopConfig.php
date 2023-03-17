<?php
declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Config\A\ALoopConfig;
use AlecRabbit\Spinner\Core\RunMode;

interface ILoopConfig
{
    public function getRunMode(): RunMode;

    public function isAutoStart(): bool;

    public function areSignalHandlersEnabled(): bool;

    public function isAsynchronous(): bool;

    public function getSignalHandlers(): ?iterable;
}