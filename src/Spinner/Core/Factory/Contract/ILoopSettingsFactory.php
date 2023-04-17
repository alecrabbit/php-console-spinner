<?php

declare(strict_types=1);

// 05.04.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

interface ILoopSettingsFactory
{
    public function createLoopSettings(): ILoopSettings;
}
