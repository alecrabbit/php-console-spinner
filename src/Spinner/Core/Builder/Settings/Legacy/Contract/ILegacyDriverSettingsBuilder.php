<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;

/**
 * @deprecated Will be removed
 */
interface ILegacyDriverSettingsBuilder
{
    public function build(): ILegacyDriverSettings;
}
