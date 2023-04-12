<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;

interface ISpinnerFactory
{
    public function createSpinner(?ISpinnerSettings $settings = null): ISpinner;
}
