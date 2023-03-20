<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Initialization;
use AlecRabbit\Spinner\Contract\SignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\A\ASpinnerSettings;

interface ISpinnerSettings extends IDefaultsChild
{
    public static function getInstance(
        IDefaults $parent,
    ): ISpinnerSettings;

    public function getInterval(): IInterval;

    public function getInitializationOption(): Initialization;

    public function overrideInitializationOption(Initialization $initialization): static;

    public function overrideInterval(IInterval $interval): static;
}
