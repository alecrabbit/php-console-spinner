<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;

final class SpinnerSettings implements ISpinnerSettings
{
    public function getInterval(): IInterval
    {
        // TODO: Implement getInterval() method.
    }

    public function getInitializationOption(): OptionInitialization
    {
        // TODO: Implement getInitializationOption() method.
    }

    public function setInitializationOption(OptionInitialization $initialization): static
    {
        // TODO: Implement setInitializationOption() method.
    }

    public function setInterval(IInterval $interval): static
    {
        // TODO: Implement setInterval() method.
    }
}