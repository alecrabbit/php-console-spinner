<?php

declare(strict_types=1);

// 05.04.23

namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;

final class AuxSettingsBuilder implements IAuxSettingsBuilder
{
    public function build(): IAuxSettings
    {
        return new AuxSettings(
            optionNormalizerMode: OptionNormalizerMode::BALANCED,
        );
    }
}
