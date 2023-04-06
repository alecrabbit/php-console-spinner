<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttach;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;

final class SpinnerSettings implements ISpinnerSettings
{
    public function __construct(
        protected OptionInitialization $initializationOption,
        protected OptionAttach $attachOption,
    ) {
    }

    public function getInitializationOption(): OptionInitialization
    {
        return $this->initializationOption;
    }

    public function setInitializationOption(OptionInitialization $initialization): ISpinnerSettings
    {
        $this->initializationOption = $initialization;
        return $this;
    }

    public function getAttachOption(): OptionAttach
    {
        return $this->attachOption;
    }

    public function setAttachOption(OptionAttach $attach): ISpinnerSettings
    {
        $this->attachOption = $attach;
        return $this;
    }
}
