<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\A\SpinnerSetup;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;

interface ISpinnerSetup
{

    public function setup(ISpinner $spinner): void;

    public function enableInitialization(bool $enable): ISpinnerSetup;

    public function enableAttacher(bool $enable): ISpinnerSetup;

}
