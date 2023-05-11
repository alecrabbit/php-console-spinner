<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Contract\Option\OptionLinker;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;

final class DriverSettingsBuilder implements IDriverSettingsBuilder
{
    public function build(): IDriverSettings
    {
        return
            new DriverSettings(
                optionInitialization: OptionInitialization::ENABLED,
                optionLinker: OptionLinker::ENABLED,
                finalMessage: PHP_EOL,
                interruptMessage: PHP_EOL,
            );
    }
}
