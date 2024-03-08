<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\ExecutionOption;

interface IGeneralSettings extends ISettingsElement
{
    public function getExecutionOption(): ExecutionOption;
}
