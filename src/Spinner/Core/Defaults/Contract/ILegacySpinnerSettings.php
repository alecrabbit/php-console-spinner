<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttach;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;

interface ILegacySpinnerSettings
{
    public function getInitializationOption(): OptionInitialization;

    public function setInitializationOption(OptionInitialization $initialization): ILegacySpinnerSettings;

    public function getAttachOption(): OptionAttach;

    public function setAttachOption(OptionAttach $attach): ILegacySpinnerSettings;
}
