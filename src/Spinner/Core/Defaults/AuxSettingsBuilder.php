<?php

declare(strict_types=1);

// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;

final class AuxSettingsBuilder implements IAuxSettingsBuilder
{
    public function build(): IAuxSettings
    {
        return
            new AuxSettings(
                optionNormalizerMode: OptionNormalizerMode::BALANCED,
                optionCursor: OptionCursor::HIDDEN,
                optionStyleMode: OptionStyleMode::ANSI8,
                outputStream: STDERR
            );
    }
}
