<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;

final class LoopSettingsFactory implements ILoopSettingsFactory
{
    public function __construct(
        protected ?ILoopProbe $loopProbe = null,
        protected ?ISignalProcessingProbe $signalProcessingProbe = null,
    ) {
    }

    public function createLoopSettings(): ILoopSettings
    {
        $loopAvailable = $this->isLoopAvailable();

        $optionAutoStart =
            $loopAvailable
                ? OptionAutoStart::ENABLED
                : OptionAutoStart::DISABLED;

        $signalProcessingAvailable = $this->isSignalProcessingAvailable();

        $optionAttachHandlers =
            $signalProcessingAvailable
                ? OptionAttachHandlers::ENABLED
                : OptionAttachHandlers::DISABLED;

        return
            new LoopSettings(
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
            $this->signalProcessingProbe instanceof ISignalProcessingProbe => $this->signalProcessingProbe->isAvailable(
            ),
            default => false,
        };
    }
}
