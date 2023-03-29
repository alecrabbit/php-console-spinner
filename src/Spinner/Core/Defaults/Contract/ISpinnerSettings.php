<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\OptionInitialization;

interface ISpinnerSettings
{
    public function getInitializationOption(): OptionInitialization;

    public function setInitializationOption(OptionInitialization $initialization): ISpinnerSettings;
}
