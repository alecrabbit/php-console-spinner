<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Legacy;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;

/**
 * @deprecated Will be removed
 */
final class LegacySpinnerConfig implements ILegacySpinnerConfig
{
    public function __construct(
        protected ILegacyWidgetConfig $widgetConfig,
    ) {
    }

    public function getWidgetConfig(): ILegacyWidgetConfig
    {
        return $this->widgetConfig;
    }
}
