<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;

interface ILegacyAuxSettings
{
    public function getNormalizerMethodMode(): NormalizerMethodMode;

    public function setNormalizerMethodMode(NormalizerMethodMode $normalizerMethodMode): ILegacyAuxSettings;
}
