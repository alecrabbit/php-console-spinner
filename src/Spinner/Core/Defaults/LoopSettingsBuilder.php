<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
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
                ? OptionSignalHandlers::ENABLED
                : OptionSignalHandlers::DISABLED;

        return
            new LoopSettings(
                runModeOption: $runModeOption,
                autoStartOption: $autoStartOption,
                signalHandlersOption: $signalHandlersOption,
            );
    }
}
