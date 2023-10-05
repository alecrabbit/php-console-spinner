<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;

/**
 * @deprecated
 */
interface ILoopSettingsFactory
{
    public function createLoopSettings(): ILegacyLoopSettings;
}
