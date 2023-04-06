<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionAttachHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

final class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected OptionRunMode $runModeOption,
        protected OptionAutoStart $autoStartOption,
        protected OptionAttachHandlers $signalHandlersOption,
    ) {
    }

    public function getRunModeOption(): OptionRunMode
    {
        return $this->runModeOption;
    }

    public function setRunModeOption(OptionRunMode $runModeOption): ILoopSettings
    {
        $this->runModeOption = $runModeOption;
        return $this;
    }

    public function getAutoStartOption(): OptionAutoStart
    {
        return $this->autoStartOption;
    }

    public function setAutoStartOption(OptionAutoStart $autoStartOption): ILoopSettings
    {
        $this->autoStartOption = $autoStartOption;
        return $this;
    }

    public function getSignalHandlersOption(): OptionAttachHandlers
    {
        return $this->signalHandlersOption;
    }

    public function setSignalHandlersOption(OptionAttachHandlers $signalHandlersOption): ILoopSettings
    {
        $this->signalHandlersOption = $signalHandlersOption;
        return $this;
    }
}
