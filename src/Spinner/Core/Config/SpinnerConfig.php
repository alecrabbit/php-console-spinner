<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacyWidgetConfig;

final class SpinnerConfig implements ISpinnerConfig
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
