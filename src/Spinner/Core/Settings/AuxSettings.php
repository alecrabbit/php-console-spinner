<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected NormalizerMethodMode $normalizerMethodMode,
    ) {
    }

    public function getNormalizerMethodMode(): NormalizerMethodMode
    {
        return $this->normalizerMethodMode;
    }

    public function setNormalizerMethodMode(NormalizerMethodMode $normalizerMethodMode): IAuxSettings
    {
        $this->normalizerMethodMode = $normalizerMethodMode;
        return $this;
    }
}
