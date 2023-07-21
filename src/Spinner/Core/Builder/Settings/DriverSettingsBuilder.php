<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Option\DriverInitializationOption;
use AlecRabbit\Spinner\Contract\Option\DriverLinkerOption;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\LegacyDriverSettings;

final class DriverSettingsBuilder implements IDriverSettingsBuilder
{
    public function build(): ILegacyDriverSettings
    {
        return
            new LegacyDriverSettings(
                optionDriverInitialization: DriverInitializationOption::ENABLED,
                optionLinker: DriverLinkerOption::ENABLED,
                finalMessage: '',
                interruptMessage: PHP_EOL,
            );
    }
}
