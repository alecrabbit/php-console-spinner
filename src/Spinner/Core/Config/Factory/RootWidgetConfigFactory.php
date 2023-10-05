<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class RootWidgetConfigFactory implements IRootWidgetConfigFactory
{
    private IRootWidgetConfig $widgetConfig;

    public function __construct(
        IConfigProvider $configProvider,
    ) {
        $this->widgetConfig = $this->extractWidgetConfig($configProvider->getConfig());
    }

    private function extractWidgetConfig(IConfig $config): IRootWidgetConfig
    {
        return $config->get(IRootWidgetConfig::class);
    }

    public function create(?IWidgetSettings $widgetSettings = null): IRootWidgetConfig
    {
        if ($widgetSettings === null) {
            return $this->widgetConfig;
        }

        $leadingSpacer = $this->getLeadingSpacer($widgetSettings);
        $trailingSpacer = $this->getTrailingSpacer($widgetSettings);
        $revolverConfig = $this->getWidgetRevolverConfig($widgetSettings);

        return
            new RootWidgetConfig(
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
