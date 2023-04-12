<?php
declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;

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
