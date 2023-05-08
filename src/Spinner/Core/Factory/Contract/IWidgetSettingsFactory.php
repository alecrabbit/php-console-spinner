<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

interface IWidgetSettingsFactory
{
    public function createFromConfig(IWidgetConfig $config): IWidgetSettings;
}
