<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyWidgetSettings;

interface IWidgetSettingsFactory
{
    public function createFromConfig(ILegacyWidgetConfig $config): ILegacyWidgetSettings;
}
