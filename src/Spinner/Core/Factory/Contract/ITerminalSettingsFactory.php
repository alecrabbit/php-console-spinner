<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;

interface ITerminalSettingsFactory
{
    public function createTerminalSettings(): ILegacyTerminalSettings;
}
