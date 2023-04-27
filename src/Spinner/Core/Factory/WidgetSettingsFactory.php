<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;

final class WidgetSettingsFactory implements IWidgetSettingsFactory
{
    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected IWidgetSettingsBuilder $widgetSettingsBuilder,
    ) {
    }

    public function createFromConfig(IWidgetConfig $config): IWidgetSettings
    {
        $config = $this->refineConfig($config);

        return
            $this->widgetSettingsBuilder
                ->withLeadingSpacer($config->getLeadingSpacer())
                ->withTrailingSpacer($config->getTrailingSpacer())
                ->withStylePattern($config->getStylePattern())
                ->withCharPattern($config->getCharPattern())
                ->build()
        ;
    }

    private function refineConfig(IWidgetConfig $config): IWidgetConfig
    {
        $widgetConfig = $this->defaultsProvider->getWidgetConfig();

        $rootWidgetConfig = $this->defaultsProvider->getRootWidgetConfig()->merge($widgetConfig);

        return
            $config->merge($rootWidgetConfig);
    }
}
