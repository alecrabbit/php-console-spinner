<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyAuxSettingsBuilder;

interface ISettings
{

    public function getAuxSettings(): IAuxSettings;
}
