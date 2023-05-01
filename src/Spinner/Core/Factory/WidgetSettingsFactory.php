<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class WidgetSettingsFactory implements IWidgetSettingsFactory
{
    public function __construct(
        protected ISettingsProvider $defaultsProvider,
        protected IWidgetSettingsBuilder $widgetSettingsBuilder,
    ) {
    }

    public function createFromConfig(IWidgetConfig $config): IWidgetSettings
    {
        $config = $config->merge($this->defaultsProvider->getWidgetConfig());

        return
            $this->widgetSettingsBuilder
                ->withLeadingSpacer($config->getLeadingSpacer())
                ->withTrailingSpacer($config->getTrailingSpacer())
                ->withStylePattern($config->getStylePattern())
                ->withCharPattern($config->getCharPattern())
                ->build()
        ;
    }

}
