<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;

/**
 * @deprecated Will be removed
 */
interface ILegacySettingsProviderBuilder
{
    public function build(): ILegacySettingsProvider;
}
