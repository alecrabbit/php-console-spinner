<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\LegacyAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyAuxSettings;

final class LegacyAuxSettingsBuilder implements ILegacyAuxSettingsBuilder
{
    public function build(): ILegacyAuxSettings
    {
        return
            new LegacyAuxSettings(
                normalizerMethodMode: NormalizerMethodMode::BALANCED,
            );
    }
}
