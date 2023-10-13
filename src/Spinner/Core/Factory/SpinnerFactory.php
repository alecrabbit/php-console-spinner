<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected IWidgetFactory $widgetFactory,
        protected IRootWidgetConfig $rootWidgetConfig,
    ) {
    }

    public function create(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $widget =
            $this->createWidget(
                $spinnerSettings?->getWidgetSettings()
            );

        return
            new Spinner($widget);
    }

    protected function createWidget(?IWidgetSettings $widgetSettings): IWidget
    {
        return
            $this->widgetFactory->create(
                $widgetSettings ?? $this->rootWidgetConfig
            );
    }

}
