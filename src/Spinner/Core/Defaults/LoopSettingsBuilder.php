<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Contract\Option\OptionRunMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

final class LoopSettingsBuilder implements ILoopSettingsBuilder
{
    public function __construct(
        protected ?ILoopProbe $loopProbe = null,
    ) {
    }

    public function build(): ILoopSettings
    {
        $probe = $this->loopProbe instanceof ILoopProbe;

        $runModeOption =
            $probe
                ? OptionRunMode::ASYNC
                : OptionRunMode::SYNCHRONOUS;

        $autoStartOption =
            $probe
                ? OptionAutoStart::ENABLED
                : OptionAutoStart::DISABLED;

        $signalHandlersOption =
            $probe
                ? OptionAttachHandlers::ENABLED
                : OptionAttachHandlers::DISABLED;

        return
            new LoopSettings(
                runModeOption: $runModeOption,
                autoStartOption: $autoStartOption,
                signalHandlersOption: $signalHandlersOption,
            );
    }
}
