<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected IWidgetFactory $widgetFactory,
        protected IWidgetSettingsFactory $widgetSettingsFactory,
    ) {
    }

    public function createSpinner(ISpinnerConfig|ILegacyWidgetConfig|null $config = null): ISpinner
    {
        $config = $this->extractConfig($config);

        return
            new Spinner(
                $this->widgetFactory
                    ->createWidget(
                        $this->createWidgetSettings($config)
                    ),
            );
    }

    protected function extractConfig(ISpinnerConfig|ILegacyWidgetConfig|null $config): ?ILegacyWidgetConfig
    {
        if ($config instanceof ISpinnerConfig) {
            $config = $config->getWidgetConfig();
        }
        return $config;
    }

    private function createWidgetSettings(?ILegacyWidgetConfig $config): ILegacyWidgetSettings
    {
        return
            $this->widgetSettingsFactory
                ->createFromConfig(
                    $this->refineConfig($config)
                )
        ;
    }

    private function refineConfig(?ILegacyWidgetConfig $config): ILegacyWidgetConfig
    {
        $rootWidgetConfig = $this->settingsProvider->getLegacyRootWidgetConfig();

        if ($config === null) {
            return $rootWidgetConfig;
        }

        return $config->merge($rootWidgetConfig);
    }
}
