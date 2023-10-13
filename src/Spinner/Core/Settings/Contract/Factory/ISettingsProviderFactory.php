<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

interface ISettingsProviderFactory
{
    public function create(): ISettingsProvider;
}
