<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Core\Contract\IPcntlExtensionProbe;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

final class LoopSettingsBuilder implements ILoopSettingsBuilder
{
    public function __construct(
        protected ?ILoopProbe $loopProbe = null,
        protected ?IPcntlExtensionProbe $pcntlExtensionProbe = null,
    ) {
    }

    public function build(): ILoopSettings
    {
        $loopAvailable = $this->isAvailableLoop();

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
                optionAttachHandlers: $optionAttachHandlers,
                pcntlExtensionAvailable: $this->isAvailablePcntlExtension(),
            );
    }

    protected function isAvailablePcntlExtension(): bool
    {
        return
            match (true) {
                $this->pcntlExtensionProbe instanceof IPcntlExtensionProbe => $this->pcntlExtensionProbe::isAvailable(),
                default => false,
            };
    }

    protected function isAvailableLoop(): bool
    {
        return
            match (true) {
                $this->loopProbe instanceof ILoopProbe => $this->loopProbe::isAvailable(),
                default => false,
            };
    }
}
