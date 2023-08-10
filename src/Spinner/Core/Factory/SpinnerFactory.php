<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected IWidgetFactory $widgetFactory,
        protected ILegacyWidgetSettingsFactory $widgetSettingsFactory,
//        protected IConfigProvider $configProvider,
    ) {
    }

    /**
     * @deprecated use {@see createSpinner()} instead
     */
    public function legacyCreateSpinner(ILegacySpinnerConfig|ILegacyWidgetConfig|null $config = null): ISpinner
    {
        $config = $this->extractConfig($config);

        return
            new Spinner(
                $this->widgetFactory
                    ->legacyCreateWidget(
                        $this->createWidgetSettings($config)
                    ),
            );
    }

    protected function extractConfig(ILegacySpinnerConfig|ILegacyWidgetConfig|null $config): ?ILegacyWidgetConfig
    {
        if ($config instanceof ILegacySpinnerConfig) {
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

    public function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        return
            new Spinner(
                $this->widgetFactory
                    ->createWidget(
                        $spinnerSettings?->getWidgetSettings()
                    )
            );
    }
}
