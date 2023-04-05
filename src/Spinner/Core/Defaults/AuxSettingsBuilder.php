<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Interval;

final class AuxSettingsBuilder implements IAuxSettingsBuilder
{
    public function build(): IAuxSettings
    {
        return
            new AuxSettings(
                interval: new Interval(1000),
                normalizerMode: NormalizerMode::BALANCED,
                cursorOption: OptionCursor::HIDDEN,
                optionStyleMode: OptionStyleMode::ANSI8,
                outputStream: STDERR
            );
    }
}
