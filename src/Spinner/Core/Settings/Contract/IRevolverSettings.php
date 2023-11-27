<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Core\Contract\ITolerance;

interface IRevolverSettings extends ISettingsElement
{
    public function getTolerance(): ?ITolerance;
}
