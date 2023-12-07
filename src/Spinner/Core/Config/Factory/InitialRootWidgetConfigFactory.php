<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IInitialRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Exception\DomainException;

final readonly class InitialRootWidgetConfigFactory implements IInitialRootWidgetConfigFactory
{
    public function __construct(
        protected IRootWidgetSettingsSolver $rootWidgetSettingsSolver,
        protected IWidgetSettingsSolver $widgetSettingsSolver,
    ) {
    }

    public function create(): IRootWidgetConfig
    {
        $rootWidgetSettings = $this->rootWidgetSettingsSolver->solve();
        $widgetSettings = $this->widgetSettingsSolver->solve();

        return new RootWidgetConfig(
            leadingSpacer: $this->getLeadingSpacer($rootWidgetSettings, $widgetSettings),
            trailingSpacer: $this->getTrailingSpacer($rootWidgetSettings, $widgetSettings),
            revolverConfig: $this->getWidgetRevolverConfig($rootWidgetSettings, $widgetSettings),
        );
    }

    private function getLeadingSpacer(
        IRootWidgetSettings $rootWidgetSettings,
        IWidgetSettings $widgetSettings
    ): IFrame {
        return $rootWidgetSettings->getLeadingSpacer()
            ??
            $widgetSettings->getLeadingSpacer()
            ??
            throw new DomainException('Leading spacer expected to be set.');
    }

    private function getTrailingSpacer(
        IRootWidgetSettings $rootWidgetSettings,
        IWidgetSettings $widgetSettings
    ): IFrame {
        return $rootWidgetSettings->getTrailingSpacer()
            ??
            $widgetSettings->getTrailingSpacer()
            ??
            throw new DomainException('Trailing spacer expected to be set.');
    }

    private function getWidgetRevolverConfig(
        IRootWidgetSettings $rootWidgetSettings,
        IWidgetSettings $widgetSettings
    ): IWidgetRevolverConfig {
        return new WidgetRevolverConfig(
            stylePalette: $this->getStylePalette($rootWidgetSettings, $widgetSettings),
            charPalette: $this->getCharPalette($rootWidgetSettings, $widgetSettings),
            revolverConfig: $this->getRevolverConfig(),
        );
    }

    private function getStylePalette(
        IRootWidgetSettings $rootWidgetSettings,
        IWidgetSettings $widgetSettings
    ): IStylePalette {
        return $rootWidgetSettings->getStylePalette()
            ??
            $widgetSettings->getStylePalette()
            ??
            throw new DomainException('Style palette expected to be set.');
    }

    private function getCharPalette(
        IRootWidgetSettings $rootWidgetSettings,
        IWidgetSettings $widgetSettings
    ): ICharPalette {
        return $rootWidgetSettings->getCharPalette()
            ??
            $widgetSettings->getCharPalette()
            ??
            throw new DomainException('Char palette expected to be set.');
    }

    private function getRevolverConfig(): IRevolverConfig
    {
        return new RevolverConfig();
    }
}
