<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class WidgetConfigFactory implements IWidgetConfigFactory
{
    public function create(?IWidgetSettings $widgetSettings = null): IWidgetConfig
    {
        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer,
                trailingSpacer: $trailingSpacer,
                stylePattern: $stylePattern,
                charPattern: $charPattern,
            );
    }
}
