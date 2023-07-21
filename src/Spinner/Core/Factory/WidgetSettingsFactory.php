<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;

final class WidgetSettingsFactory implements IWidgetSettingsFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected ILegacyWidgetSettingsBuilder $widgetSettingsBuilder,
    ) {
    }

    public function createFromConfig(ILegacyWidgetConfig $config): ILegacyWidgetSettings
    {
        $config = $config->merge($this->settingsProvider->getLegacyWidgetConfig());

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
