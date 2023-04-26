<?php

declare(strict_types=1);

// 29.03.23

namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected OptionNormalizerMode $optionNormalizerMode = OptionNormalizerMode::BALANCED,
    ) {
    }

    public function getOptionNormalizerMode(): OptionNormalizerMode
    {
        return $this->optionNormalizerMode;
    }

    public function setOptionNormalizerMode(OptionNormalizerMode $optionNormalizerMode): IAuxSettings
    {
        $this->optionNormalizerMode = $optionNormalizerMode;
        return $this;
    }
}
