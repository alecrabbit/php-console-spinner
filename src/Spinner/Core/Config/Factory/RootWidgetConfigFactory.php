<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class RootWidgetConfigFactory implements IRootWidgetConfigFactory
{
    public function __construct(
        // inject solver for WidgetSettings or for individual settings
    )
    {
    }

    public function create(?IWidgetSettings $widgetSettings = null): IWidgetConfig
    {
        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer,
                trailingSpacer: $trailingSpacer,
                revolverConfig: $revolverConfig,
            );
    }
}
