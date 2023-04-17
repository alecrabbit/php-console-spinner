<?php

declare(strict_types=1);

// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;

final class DriverSettingsBuilder implements IDriverSettingsBuilder
{
    public function build(): IDriverSettings
    {
        return new DriverSettings(
            optionInitialization: OptionInitialization::ENABLED,
            optionAttacher: OptionAttacher::ENABLED,
        );
    }
}
