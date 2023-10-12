<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Exception\DomainException;

final class WidgetConfigFactory implements IWidgetConfigFactory
{
    private IWidgetSettings $widgetSettings;

    public function __construct(
        IWidgetSettingsSolver $widgetSettingsSolver,
    ) {
        $this->widgetSettings = $widgetSettingsSolver->solve();
    }

    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetConfig
    {
        self::assertWidgetSettings($widgetSettings);

        return
            new WidgetConfig(
                leadingSpacer: $this->getLeadingSpacer(),
                trailingSpacer: $this->getTrailingSpacer(),
                revolverConfig: $this->getWidgetRevolverConfig(),
            );
    }

    private static function assertWidgetSettings(IWidgetConfig|IWidgetSettings|null $widgetSettings): void
    {
        match (true) {
            $widgetSettings instanceof IWidgetSettings => throw new DomainException('Widget settings is not expected.'),
            $widgetSettings instanceof IWidgetConfig => throw new DomainException('Widget config is not expected.'),
            default => null,
        };
    }

    protected function getLeadingSpacer(): IFrame
    {
        return
            $this->widgetSettings->getLeadingSpacer();
    }

    protected function getTrailingSpacer(): IFrame
    {
        return
            $this->widgetSettings->getTrailingSpacer();
    }

    private function getWidgetRevolverConfig(): IWidgetRevolverConfig
    {
        return
            new WidgetRevolverConfig(
                stylePalette: $this->widgetSettings->getStylePalette(),
                charPalette: $this->widgetSettings->getCharPalette(),
                revolverConfig: new RevolverConfig(),
            );
    }
}
