<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class WidgetConfigFactory implements IWidgetConfigFactory
{
    private IConfig $config;

    public function __construct(
        IConfigProvider $configProvider,
    ) {
        $this->config = $configProvider->getConfig();
    }

    public function create(?IWidgetSettings $widgetSettings = null): IWidgetConfig
    {
        if ($widgetSettings === null) {
            return $this->getWidgetConfig();
        }

        $leadingSpacer = $this->getLeadingSpacer($widgetSettings);
        $trailingSpacer = $this->getTrailingSpacer($widgetSettings);
        $revolverConfig = $this->getRevolverConfig($widgetSettings);

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
            $this->getWidgetConfig()->getLeadingSpacer();
    }

    protected function getWidgetConfig(): IWidgetConfig
    {
        return $this->config->get(IWidgetConfig::class);
    }

    protected function getTrailingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getTrailingSpacer()
            ??
            $this->getWidgetConfig()->getTrailingSpacer();
    }

    private function getRevolverConfig(IWidgetSettings $widgetSettings): IWidgetRevolverConfig
    {
        $config = $this->getWidgetConfig()->getRevolverConfig();

        return
            new WidgetRevolverConfig(
                stylePalette: $widgetSettings->getStylePalette() ?? $config->getStylePalette(),
                charPalette: $widgetSettings->getCharPalette() ?? $config->getCharPalette(),
                revolverConfig: $config->getRevolverConfig(),
            );
    }
}
