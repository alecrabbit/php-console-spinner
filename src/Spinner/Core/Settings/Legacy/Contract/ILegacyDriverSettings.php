<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
interface ILegacyDriverSettings
{
    public function getFinalMessage(): string;

    public function setFinalMessage(string $finalMessage): ILegacyDriverSettings;

    public function getInterruptMessage(): string;

    public function setInterruptMessage(string $interruptMessage): ILegacyDriverSettings;

    public function isInitializationEnabled(): bool;

    public function isLinkerEnabled(): bool;

    public function setOptionDriverInitialization(
        InitializationOption $optionDriverInitialization,
    ): ILegacyDriverSettings;

    public function getOptionLinker(): LinkerOption;

    public function setOptionLinker(LinkerOption $optionLinker): ILegacyDriverSettings;
}
