<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionLinker;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;

interface IDriverSettings
{
    public function getFinalMessage(): string;

    public function setFinalMessage(string $finalMessage): IDriverSettings;

    public function getInterruptMessage(): string;

    public function setInterruptMessage(string $interruptMessage): IDriverSettings;

    public function isInitializationEnabled(): bool;

    public function isLinkerEnabled(): bool;

    public function setOptionInitialization(OptionInitialization $optionInitialization): IDriverSettings;

    public function getOptionLinker(): OptionLinker;

    public function setOptionLinker(OptionLinker $optionLinker): IDriverSettings;
}
