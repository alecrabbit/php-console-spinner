<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionRunMode;

interface ILoopConfig
{
    public function isEnabledAutoStart(): bool;

    public function isEnabledAttachHandlers(): bool;

    public function isRunModeAsynchronous(): bool;

    public function getRunModeOption(): OptionRunMode;
}
