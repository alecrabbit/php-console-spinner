<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacySpinnerConfig;

final class LegacySpinnerConfig implements ILegacySpinnerConfig
{
    public function __construct(
        protected OptionInitialization $initializationOption,
        protected OptionAttacher $attachOption,
    ) {
    }

    public function isEnabledInitialization(): bool
    {
        return $this->initializationOption === OptionInitialization::ENABLED;
    }

    public function isEnabledAttach(): bool
    {
        return $this->attachOption === OptionAttacher::ENABLED;
    }
}
