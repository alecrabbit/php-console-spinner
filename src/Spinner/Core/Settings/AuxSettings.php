<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\NormalizerMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected NormalizerMethodOption $optionNormalizerMode = NormalizerMethodOption::BALANCED,
    ) {
    }

    public function getOptionNormalizerMode(): NormalizerMethodOption
    {
        return $this->optionNormalizerMode;
    }

    public function setOptionNormalizerMode(NormalizerMethodOption $optionNormalizerMode): IAuxSettings
    {
        $this->optionNormalizerMode = $optionNormalizerMode;
        return $this;
    }
}
