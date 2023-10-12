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
    public function __construct(
        protected IWidgetSettingsSolver $widgetSettingsSolver,
    ) {
    }

    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetConfig
    {
        self::assertWidgetSettings($widgetSettings);

        $widgetSettings = $this->widgetSettingsSolver->solve();

        return
            new WidgetConfig(
                leadingSpacer: $this->getLeadingSpacer($widgetSettings),
                trailingSpacer: $this->getTrailingSpacer($widgetSettings),
                revolverConfig: $this->getWidgetRevolverConfig($widgetSettings),
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

    protected function getLeadingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getLeadingSpacer()
            ??
            throw new DomainException('Leading spacer expected to be set.');
    }

    protected function getTrailingSpacer(IWidgetSettings $widgetSettings): IFrame
    {
        return
            $widgetSettings->getTrailingSpacer()
            ??
            throw new DomainException('Trailing spacer expected to be set.');
    }

    private function getWidgetRevolverConfig(IWidgetSettings $widgetSettings): IWidgetRevolverConfig
    {
        $stylePalette =
            $widgetSettings->getStylePalette()
            ??
            throw new DomainException('Style palette expected to be set.');

        $charPalette =
            $widgetSettings->getCharPalette()
            ??
            throw new DomainException('Char palette expected to be set.');

        return
            new WidgetRevolverConfig(
                stylePalette: $stylePalette,
                charPalette: $charPalette,
                revolverConfig: new RevolverConfig(),
            );
    }
}
