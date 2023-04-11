<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;

final class SpinnerConfig implements ISpinnerConfig
{
    public function __construct(
        protected OptionInitialization $initializationOption,
    ) {
    }

    public function isEnabledInitialization(): bool
    {
        return $this->initializationOption === OptionInitialization::ENABLED;
    }
}
