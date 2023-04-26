<?php

declare(strict_types=1);
// 20.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;

interface IWidgetSettingsFactory
{
    public function createFromConfig(IWidgetConfig $config): IWidgetSettings;
}
