<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;

final class WidgetConfigFactory implements IWidgetConfigFactory
{
    public function create(): IWidgetConfig
    {
        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer,
                trailingSpacer: $trailingSpacer,
                stylePalette: $stylePalette,
                charPalette: $charPalette,
            );
    }
}
