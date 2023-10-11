<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;

/**
 * @deprecated
 */
interface ILegacyLoopSettingsFactory
{
    public function createLoopSettings(): ILegacyLoopSettings;
}
