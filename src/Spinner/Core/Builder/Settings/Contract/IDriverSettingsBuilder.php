<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyDriverSettings;

interface IDriverSettingsBuilder
{
    public function build(): ILegacyDriverSettings;
}
