<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionAttachHandlers;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;

final class LoopConfig implements ILoopConfig
{
    public function __construct(
        protected OptionRunMode $runModeOption,
        protected OptionAutoStart $autoStartOption,
        protected OptionAttachHandlers $attachHandlersOption,
    ) {
    }

    public function isRunModeAsynchronous(): bool
    {
        return $this->runModeOption === OptionRunMode::ASYNC;
    }

    public function isEnabledAutoStart(): bool
    {
        return $this->autoStartOption === OptionAutoStart::ENABLED;
    }

    public function isEnabledAttachHandlers(): bool
    {
        return $this->attachHandlersOption === OptionAttachHandlers::ENABLED;
    }

    public function getRunModeOption(): OptionRunMode
    {
        return $this->runModeOption;
    }
}
