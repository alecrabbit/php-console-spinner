<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

interface IDisabledDriverDetector
{
    public function isDisabled(): bool;
}
