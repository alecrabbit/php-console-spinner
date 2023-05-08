<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;

interface IAuxSettings
{
    public function getOptionNormalizerMode(): OptionNormalizerMode;

    public function setOptionNormalizerMode(OptionNormalizerMode $normalizerMode): IAuxSettings;
}
