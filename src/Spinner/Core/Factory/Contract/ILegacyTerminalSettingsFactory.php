<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;


/**
 * @deprecated Will be removed
 */
interface ILegacyTerminalSettingsFactory
{
    public function createTerminalSettings(): ILegacyTerminalSettings;
}
