<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;

interface ISpinnerFactory
{
    public function create(?ISpinnerSettings $spinnerSettings = null): ISpinner;
}
