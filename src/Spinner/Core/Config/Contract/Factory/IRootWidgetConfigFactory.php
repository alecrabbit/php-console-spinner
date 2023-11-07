<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

interface IRootWidgetConfigFactory extends IWidgetConfigFactory
{
    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IRootWidgetConfig;
}
