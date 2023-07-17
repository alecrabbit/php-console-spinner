<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\NormalizerMethodOption;

interface IAuxSettings
{
    public function getOptionNormalizerMode(): NormalizerMethodOption;

    public function setOptionNormalizerMode(NormalizerMethodOption $normalizerMode): IAuxSettings;
}
