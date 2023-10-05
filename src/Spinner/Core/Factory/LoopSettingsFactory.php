<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyLoopSettings;

/**
 * @deprecated
 */
final class LoopSettingsFactory implements ILoopSettingsFactory
{
    public function __construct(
        protected ?ILoopProbe $loopProbe = null,
        protected ?ILegacySignalProcessingLegacyProbe $signalProcessingProbe = null,
    ) {
    }

    public function createLoopSettings(): ILegacyLoopSettings
    {
        $loopAvailable = $this->isLoopAvailable();

        $optionAutoStart =
            $loopAvailable
                ? AutoStartOption::ENABLED
                : AutoStartOption::DISABLED;

        $signalProcessingAvailable = $this->isSignalProcessingAvailable();

        $optionAttachHandlers =
            $signalProcessingAvailable
                ? SignalHandlersOption::ENABLED
                : SignalHandlersOption::DISABLED;

        return
            new LegacyLoopSettings(
                loopAvailable: $loopAvailable,
                optionAutoStart: $optionAutoStart,
                signalProcessingAvailable: $signalProcessingAvailable,
                optionAttachHandlers: $optionAttachHandlers,
            );
    }

    private function isLoopAvailable(): bool
    {
        return match (true) {
            $this->loopProbe instanceof ILoopProbe => $this->loopProbe::isSupported(),
            default => false,
        };
    }

    private function isSignalProcessingAvailable(): bool
    {
        return match (true) {
            $this->signalProcessingProbe instanceof ILegacySignalProcessingLegacyProbe => $this->signalProcessingProbe->isAvailable(
            ),
            default => false,
        };
    }
}
