<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final readonly class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected IWidgetFactory $widgetFactory,
        protected IRootWidgetConfigFactory $widgetConfigFactory,
    ) {
    }

    public function create(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $widget =
            $this->createWidget(
                $spinnerSettings?->getWidgetSettings()
            );

        return
            new Spinner(
                widget: $widget
            );
    }

    protected function createWidget(?IWidgetSettings $widgetSettings): IWidget
    {
        $widgetConfig = $this->widgetConfigFactory->create($widgetSettings);

        return
            $this->widgetFactory->create($widgetConfig);
    }
}
