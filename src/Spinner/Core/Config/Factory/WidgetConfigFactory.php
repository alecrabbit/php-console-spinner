<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final readonly class WidgetConfigFactory implements IWidgetConfigFactory
{
    public function __construct(
        protected IWidgetConfig $widgetConfig,
    ) {
    }

    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetConfig
    {
        if ($widgetSettings instanceof IWidgetConfig) {
            return $widgetSettings;
        }

        if ($widgetSettings === null) {
            return $this->widgetConfig;
        }

        $leadingSpacer = $this->getLeadingSpacer($widgetSettings);
        $trailingSpacer = $this->getTrailingSpacer($widgetSettings);
        $revolverConfig = $this->getWidgetRevolverConfig($widgetSettings);

        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer,
                trailingSpacer: $trailingSpacer,
                revolverConfig: $revolverConfig,
            );
    }

    protected function getLeadingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getLeadingSpacer()
            ??
            $this->widgetConfig->getLeadingSpacer();
    }

    protected function getTrailingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getTrailingSpacer()
            ??
            $this->widgetConfig->getTrailingSpacer();
    }

    private function getWidgetRevolverConfig(IWidgetSettings $widgetSettings): IWidgetRevolverConfig
    {
        $config = $this->widgetConfig->getWidgetRevolverConfig();

        return
            new WidgetRevolverConfig(
                stylePalette: $widgetSettings->getStylePalette() ?? $config->getStylePalette(),
                charPalette: $widgetSettings->getCharPalette() ?? $config->getCharPalette(),
                revolverConfig: $config->getRevolverConfig(),
            );
    }
}
