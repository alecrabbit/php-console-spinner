<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

interface IRootWidgetConfigFactory
{
    public function create(?IWidgetSettings $widgetSettings = null): IWidgetConfig;
}
