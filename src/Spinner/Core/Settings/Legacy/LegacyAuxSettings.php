<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Legacy;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;

final class LegacyAuxSettings implements ILegacyAuxSettings
{
    public function __construct(
        protected NormalizerMethodMode $normalizerMethodMode,
    ) {
    }

    public function getNormalizerMethodMode(): NormalizerMethodMode
    {
        return $this->normalizerMethodMode;
    }

    public function setNormalizerMethodMode(NormalizerMethodMode $normalizerMethodMode): ILegacyAuxSettings
    {
        $this->normalizerMethodMode = $normalizerMethodMode;
        return $this;
    }
}
