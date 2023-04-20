<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected IWidgetFactory $widgetFactory,
        protected IWidgetSettingsFactory $widgetSettingsFactory,
    ) {
    }

    public function createSpinner(?ISpinnerConfig $config = null): ISpinner
    {
        return new Spinner(
            $this->widgetFactory->createWidget(
                $this->createWidgetSettings($config?->getWidgetConfig())
            ),
        );
    }

    private function createWidgetSettings(?IWidgetConfig $config): IWidgetSettings
    {
        if ($config === null) {
            $config = $this->defaultsProvider->getRootWidgetConfig();
        }
        return
            $this->widgetSettingsFactory->createFromConfig($config);
    }
}
