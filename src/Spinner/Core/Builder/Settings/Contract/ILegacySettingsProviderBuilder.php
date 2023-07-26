<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Contract;

use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;

interface ILegacySettingsProviderBuilder
{
    public function build(): ILegacySettingsProvider;
}
