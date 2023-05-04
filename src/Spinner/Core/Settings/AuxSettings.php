<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;

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
