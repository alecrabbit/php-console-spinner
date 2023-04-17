<?php

declare(strict_types=1);

// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;

final class DriverSettings implements IDriverSettings
{
    public function __construct(
        protected OptionInitialization $optionInitialization,
        protected OptionAttacher $optionAttacher,
        protected string $finalMessage,
        protected string $interruptMessage,
    ) {
    }

    public function setOptionInitialization(OptionInitialization $optionInitialization): IDriverSettings
    {
        $this->optionInitialization = $optionInitialization;
        return $this;
    }

    public function setOptionAttacher(OptionAttacher $optionAttacher): IDriverSettings
    {
        $this->optionAttacher = $optionAttacher;
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
        return $this->optionInitialization === OptionInitialization::ENABLED;
    }

    public function isAttacherEnabled(): bool
    {
        return $this->optionAttacher === OptionAttacher::ENABLED;
    }

    public function getOptionAttacher(): OptionAttacher
    {
        return $this->optionAttacher;
    }
}
