<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final class SpinnerConfig implements ISpinnerConfig
{
    public function __construct(
        protected IWidgetConfig $widgetConfig,
    ) {
    }

    public function getWidgetConfig(): IWidgetConfig
    {
        return $this->widgetConfig;
    }
}
