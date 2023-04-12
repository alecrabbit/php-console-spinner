<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettings;

final class LegacySpinnerSettings implements ILegacySpinnerSettings
{
    public function __construct(
        protected OptionInitialization $initializationOption,
        protected OptionAttacher $attachOption,
    ) {
    }

    public function getInitializationOption(): OptionInitialization
    {
        return $this->initializationOption;
    }

    public function setInitializationOption(OptionInitialization $initialization): ILegacySpinnerSettings
    {
        $this->initializationOption = $initialization;
        return $this;
    }

    public function getAttachOption(): OptionAttacher
    {
        return $this->attachOption;
    }

    public function setAttachOption(OptionAttacher $attach): ILegacySpinnerSettings
    {
        $this->attachOption = $attach;
        return $this;
    }
}
