<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final readonly class RuntimeRootWidgetConfigFactory implements IRuntimeRootWidgetConfigFactory
{
    public function __construct(
        protected IRootWidgetConfig $rootWidgetConfig,
    ) {
    }

    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IRootWidgetConfig
    {
        if ($widgetSettings === null) {
            return $this->rootWidgetConfig;
        }

        if ($widgetSettings instanceof IWidgetConfig) {
            return
                new RootWidgetConfig(
                    leadingSpacer: $widgetSettings->getLeadingSpacer(),
                    trailingSpacer: $widgetSettings->getTrailingSpacer(),
                    revolverConfig: $widgetSettings->getWidgetRevolverConfig(),
                );
        }

        return
            new RootWidgetConfig(
                leadingSpacer: $this->getLeadingSpacer($widgetSettings),
                trailingSpacer: $this->getTrailingSpacer($widgetSettings),
                revolverConfig: $this->getWidgetRevolverConfig($widgetSettings),
            );
    }


    protected function getLeadingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getLeadingSpacer()
            ??
            $this->rootWidgetConfig->getLeadingSpacer();
    }

    protected function getTrailingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getTrailingSpacer()
            ??
            $this->rootWidgetConfig->getTrailingSpacer();
    }

    private function getWidgetRevolverConfig(IWidgetSettings $widgetSettings): IWidgetRevolverConfig
    {
        $wRConfig = $this->rootWidgetConfig->getWidgetRevolverConfig();

        return
            new WidgetRevolverConfig(
                stylePalette: $widgetSettings->getStylePalette() ?? $wRConfig->getStylePalette(),
                charPalette: $widgetSettings->getCharPalette() ?? $wRConfig->getCharPalette(),
                revolverConfig: $wRConfig->getRevolverConfig(),
            );
    }
}
