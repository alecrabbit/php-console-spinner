<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionDriverInitialization;
use AlecRabbit\Spinner\Contract\Option\OptionLinker;

interface IDriverSettings
{
    public function getFinalMessage(): string;

    public function setFinalMessage(string $finalMessage): IDriverSettings;

    public function getInterruptMessage(): string;

    public function setInterruptMessage(string $interruptMessage): IDriverSettings;

    public function isInitializationEnabled(): bool;

    public function isLinkerEnabled(): bool;

    public function setOptionDriverInitialization(
        OptionDriverInitialization $optionDriverInitialization,
    ): IDriverSettings;

    public function getOptionLinker(): OptionLinker;

    public function setOptionLinker(OptionLinker $optionLinker): IDriverSettings;
}
