<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\LinkerOption;

interface ILinkerSettings extends ISettingsElement
{
    public function getLinkerOption(): LinkerOption;
}
