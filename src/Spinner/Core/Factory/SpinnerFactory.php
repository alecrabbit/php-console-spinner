<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ISettingsProvider $settingsProvider,
        protected IWidgetCompositeFactory $widgetFactory,
        protected IWidgetSettingsFactory $widgetSettingsFactory,
    ) {
    }

    public function createSpinner(ISpinnerConfig|IWidgetConfig|null $config = null): ISpinner
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

    protected function extractConfig(ISpinnerConfig|IWidgetConfig|null $config): ?IWidgetConfig
    {
        if ($config instanceof ISpinnerConfig) {
            $config = $config->getWidgetConfig();
        }
        return $config;
    }

    private function createWidgetSettings(?IWidgetConfig $config): IWidgetSettings
    {
        return
            $this->widgetSettingsFactory
                ->createFromConfig(
                    $this->refineConfig($config)
                )
        ;
    }

    private function refineConfig(?IWidgetConfig $config): IWidgetConfig
    {
        $rootWidgetConfig = $this->settingsProvider->getRootWidgetConfig();

        if ($config === null) {
            return $rootWidgetConfig;
        }

        return $config->merge($rootWidgetConfig);
    }
}
