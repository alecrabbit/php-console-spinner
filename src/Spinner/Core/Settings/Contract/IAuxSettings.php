<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;

interface IAuxSettings
{
    public function getNormalizerMethodMode(): NormalizerMethodMode;

    public function setNormalizerMethodMode(NormalizerMethodMode $normalizerMethodMode): IAuxSettings;
}
