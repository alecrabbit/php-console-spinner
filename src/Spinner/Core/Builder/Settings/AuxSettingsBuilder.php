<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\AuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;

final class AuxSettingsBuilder implements IAuxSettingsBuilder
{
    public function build(): IAuxSettings
    {
        return new AuxSettings(
            optionNormalizerMode: OptionNormalizerMode::BALANCED,
        );
    }
}
