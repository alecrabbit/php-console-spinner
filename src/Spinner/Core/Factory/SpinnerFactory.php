<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected IWidgetFactory $widgetFactory,
        protected IWidgetSettingsBuilder $widgetSettingsBuilder,
    ) {
    }

    public function createSpinner(?ISpinnerConfig $config = null): ISpinner
    {
        return new Spinner(
            $this->widgetFactory->createWidget(
                $this->createWidgetSettings($config)
            ),
        );
    }

    private function createWidgetSettings(?ISpinnerConfig $config): IWidgetSettings
    {
        $rootWidgetSettings = $this->defaultsProvider->getRootWidgetSettings();
        $widgetConfig = $config?->getWidgetConfig();
        if ($widgetConfig === null) {
            return $rootWidgetSettings;
        }
        return $this->widgetSettingsBuilder
            ->withLeadingSpacer($widgetConfig->getLeadingSpacer() ?? $rootWidgetSettings->getLeadingSpacer())
            ->withTrailingSpacer($widgetConfig->getTrailingSpacer() ?? $rootWidgetSettings->getTrailingSpacer())
            ->withStylePattern($widgetConfig->getStylePattern() ?? $rootWidgetSettings->getStylePattern())
            ->withCharPattern($widgetConfig->getCharPattern() ?? $rootWidgetSettings->getCharPattern())
            ->build()
        ;
    }
}
