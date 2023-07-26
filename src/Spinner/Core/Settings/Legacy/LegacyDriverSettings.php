<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;

final class LegacyDriverSettings implements ILegacyDriverSettings
{
    public function __construct(
        protected InitializationOption $optionDriverInitialization,
        protected LinkerOption $optionLinker,
        protected string $finalMessage,
        protected string $interruptMessage,
    ) {
    }

    public function setOptionDriverInitialization(
        InitializationOption $optionDriverInitialization,
    ): ILegacyDriverSettings {
        $this->optionDriverInitialization = $optionDriverInitialization;
        return $this;
    }

    public function setOptionLinker(LinkerOption $optionLinker): ILegacyDriverSettings
    {
        $this->optionLinker = $optionLinker;
        return $this;
    }

    public function setFinalMessage(string $finalMessage): ILegacyDriverSettings
    {
        $this->finalMessage = $finalMessage;
        return $this;
    }

    public function setInterruptMessage(string $interruptMessage): ILegacyDriverSettings
    {
        $this->interruptMessage = $interruptMessage;
        return $this;
    }

    /**
     * @deprecated
     */
    public function getFinalMessage(): string
    {
        return $this->finalMessage;
    }

    /**
     * @deprecated
     */
    public function getInterruptMessage(): string
    {
        return $this->interruptMessage;
    }

    public function isInitializationEnabled(): bool
    {
        return $this->optionDriverInitialization === InitializationOption::ENABLED;
    }

    public function isLinkerEnabled(): bool
    {
        return $this->optionLinker === LinkerOption::ENABLED;
    }

    public function getOptionLinker(): LinkerOption
    {
        return $this->optionLinker;
    }
}
