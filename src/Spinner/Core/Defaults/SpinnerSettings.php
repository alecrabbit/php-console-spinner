<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Interval;

final class SpinnerSettings implements ISpinnerSettings
{
    public function __construct(
        protected IInterval $interval = new Interval(),
        protected OptionInitialization $initializationOption = OptionInitialization::ENABLED,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function setInterval(IInterval $interval): ISpinnerSettings
    {
        $this->interval = $interval;
        return $this;
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
}