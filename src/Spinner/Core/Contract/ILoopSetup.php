<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;

interface ILoopSetup
{
    public function setup(ISpinner $spinner): void;

    public function enableSignalHandlers(bool $enable): ILoopSetup;

    public function asynchronous(bool $enable): ILoopSetup;

    public function enableAutoStart(bool $enable): ILoopSetup;

}
