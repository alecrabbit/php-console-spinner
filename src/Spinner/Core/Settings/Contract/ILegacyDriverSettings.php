<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\DriverInitializationOption;
use AlecRabbit\Spinner\Contract\Option\DriverLinkerOption;

interface ILegacyDriverSettings
{
    public function getFinalMessage(): string;

    public function setFinalMessage(string $finalMessage): ILegacyDriverSettings;

    public function getInterruptMessage(): string;

    public function setInterruptMessage(string $interruptMessage): ILegacyDriverSettings;

    public function isInitializationEnabled(): bool;

    public function isLinkerEnabled(): bool;

    public function setOptionDriverInitialization(
        DriverInitializationOption $optionDriverInitialization,
    ): ILegacyDriverSettings;

    public function getOptionLinker(): DriverLinkerOption;

    public function setOptionLinker(DriverLinkerOption $optionLinker): ILegacyDriverSettings;
}
