<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\DriverInitializationOption;
use AlecRabbit\Spinner\Contract\Option\DriverLinkerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;

final class DriverSettings implements IDriverSettings
{
    public function __construct(
        protected DriverInitializationOption $optionDriverInitialization,
        protected DriverLinkerOption $optionLinker,
        protected string $finalMessage,
        protected string $interruptMessage,
    ) {
    }

    public function setOptionDriverInitialization(
        DriverInitializationOption $optionDriverInitialization,
    ): IDriverSettings {
        $this->optionDriverInitialization = $optionDriverInitialization;
        return $this;
    }

    public function setOptionLinker(DriverLinkerOption $optionLinker): IDriverSettings
    {
        $this->optionLinker = $optionLinker;
        return $this;
    }

    public function setFinalMessage(string $finalMessage): IDriverSettings
    {
        $this->finalMessage = $finalMessage;
        return $this;
    }

    public function setInterruptMessage(string $interruptMessage): IDriverSettings
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
        return $this->optionDriverInitialization === DriverInitializationOption::ENABLED;
    }

    public function isLinkerEnabled(): bool
    {
        return $this->optionLinker === DriverLinkerOption::ENABLED;
    }

    public function getOptionLinker(): DriverLinkerOption
    {
        return $this->optionLinker;
    }
}
