<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;

final class AuxSettingsBuilder implements IAuxSettingsBuilder
{
    public function build(): IAuxSettings
    {
        return
            new AuxSettings(
                normalizerMethodMode: NormalizerMethodMode::BALANCED,
            );
    }
}
