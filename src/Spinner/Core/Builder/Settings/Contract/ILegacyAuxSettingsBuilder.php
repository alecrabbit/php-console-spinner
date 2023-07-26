<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Contract;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;

interface ILegacyAuxSettingsBuilder
{
    public function build(): ILegacyAuxSettings;
}
