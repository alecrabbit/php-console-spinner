<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;

interface ILegacySpinnerSettings
{
    public function getInitializationOption(): OptionInitialization;

    public function setInitializationOption(OptionInitialization $initialization): ILegacySpinnerSettings;

    public function getAttachOption(): OptionAttacher;

    public function setAttachOption(OptionAttacher $attach): ILegacySpinnerSettings;
}
