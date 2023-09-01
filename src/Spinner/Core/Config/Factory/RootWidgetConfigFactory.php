<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;

final class RootWidgetConfigFactory implements IRootWidgetConfigFactory
{
    public function __construct(
        // inject solver for WidgetSettings or for individual settings
    )
    {
    }

    public function create(): IWidgetConfig
    {
        return
            new WidgetConfig(
                leadingSpacer: '',
                trailingSpacer: '',
                stylePalette: '',
                charPalette: '',
            );
    }
}
