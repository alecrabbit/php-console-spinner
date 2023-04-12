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
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
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
        return
            new Spinner(
                $this->widgetFactory->createWidget(
                    $this->createWidgetSettings($config)
                ),
            );
    }

    protected function createWidget(?ISpinnerConfig $settings): IWidgetComposite
    {
        $widgetSettings =
            $settings?->getWidgetConfig() ?? $this->defaultsProvider->getRootWidgetSettings();

        return
            $this->widgetFactory->createWidget($widgetSettings);
    }

    protected function createWidgetSettings(?ISpinnerConfig $config): IWidgetSettings
    {
        $settings = $this->defaultsProvider->getRootWidgetSettings();
        $widgetConfig = $config?->getWidgetConfig();
        if (null === $widgetConfig) {
            return $settings;
        }
        return
            $this->widgetSettingsBuilder
                ->withLeadingSpacer($widgetConfig->getLeadingSpacer() ?? $settings->getLeadingSpacer())
                ->withTrailingSpacer($widgetConfig->getTrailingSpacer() ?? $settings->getTrailingSpacer())
                ->withStylePattern($widgetConfig->getStylePattern() ?? $settings->getStylePattern())
                ->withCharPattern($widgetConfig->getCharPattern() ?? $settings->getCharPattern())
                ->build()
        ;
    }
}
