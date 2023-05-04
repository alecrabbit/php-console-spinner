<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings\Contract;

use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;

interface ISettingsProviderBuilder
{
    public function build(): ISettingsProvider;
}
