<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;

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

        $optionAttachHandlers =
            $loopAvailable
                ? OptionAttachHandlers::ENABLED
                : OptionAttachHandlers::DISABLED;

        return
            new LoopSettings(
                loopAvailable: $loopAvailable,
                optionAutoStart: $optionAutoStart,
                signalProcessingAvailable: $this->isSignalProcessingAvailable(),
                optionAttachHandlers: $optionAttachHandlers,
            );
    }

    protected function isLoopAvailable(): bool
    {
        return
            match (true) {
                $this->loopProbe instanceof ILoopProbe => $this->loopProbe::isAvailable(),
                default => false,
            };
    }

    protected function isSignalProcessingAvailable(): bool
    {
        return
            match (true) {
                $this->signalProcessingProbe instanceof ISignalProcessingProbe
                => $this->signalProcessingProbe::isAvailable(),
                default => false,
            };
    }
}
