<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Legacy;

use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
final class LegacyWidgetSettingsFactory implements ILegacyWidgetSettingsFactory
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
