<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

final readonly class LoopSettings implements ILoopSettings
{
    public function __construct(
        protected OptionRunMode $runModeOption = OptionRunMode::ASYNC,
        protected OptionAutoStart $autoStartOption = OptionAutoStart::ENABLED,
        protected OptionSignalHandlers $signalHandlersOption = OptionSignalHandlers::ENABLED,
    ) {
    }

    public function getRunModeOption(): OptionRunMode
    {
        return $this->runModeOption;
    }

    public function setRunModeOption(OptionRunMode $runModeOption): ILoopSettings
    {
        return
            new self(
                runModeOption: $runModeOption,
                autoStartOption: $this->autoStartOption,
                signalHandlersOption: $this->signalHandlersOption
            );
    }

    public function getAutoStartOption(): OptionAutoStart
    {
        return $this->autoStartOption;
    }

    public function setAutoStartOption(OptionAutoStart $autoStartOption): ILoopSettings
    {
        return
            new self(
                runModeOption: $this->runModeOption,
                autoStartOption: $autoStartOption,
                signalHandlersOption: $this->signalHandlersOption
            );
    }

    public function getSignalHandlersOption(): OptionSignalHandlers
    {
        return $this->signalHandlersOption;
    }

    public function setSignalHandlersOption(OptionSignalHandlers $signalHandlersOption): ILoopSettings
    {
        return
            new self(
                runModeOption: $this->runModeOption,
                autoStartOption: $this->autoStartOption,
                signalHandlersOption: $signalHandlersOption
            );
    }
}