<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttach;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;

interface ISpinnerSettings
{
    public function getInitializationOption(): OptionInitialization;

    public function setInitializationOption(OptionInitialization $initialization): ISpinnerSettings;

    public function getAttachOption(): OptionAttach;

    public function setAttachOption(OptionAttach $attach): ISpinnerSettings;
}
