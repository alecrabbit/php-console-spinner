<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyDriverSettings;

final class LegacyDriverSettingsBuilder implements ILegacyDriverSettingsBuilder
{
    public function build(): ILegacyDriverSettings
    {
        return
            new LegacyDriverSettings(
                optionDriverInitialization: InitializationOption::ENABLED,
                optionLinker: LinkerOption::ENABLED,
                finalMessage: '',
                interruptMessage: PHP_EOL,
            );
    }
}
