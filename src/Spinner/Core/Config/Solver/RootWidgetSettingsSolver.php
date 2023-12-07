<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;

final readonly class RootWidgetSettingsSolver extends ASolver implements IRootWidgetSettingsSolver
{
    public function solve(): IRootWidgetSettings
    {
        return $this->doSolve(
            $this->extractSettings($this->settingsProvider->getUserSettings()),
            $this->extractSettings($this->settingsProvider->getDetectedSettings()),
            $this->extractSettings($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings,
    ): IRootWidgetSettings {
        $leadingSpacer =
            $this->getLeadingSpacer($userSettings, $detectedSettings, $defaultSettings);

        $trailingSpacer =
            $this->getTrailingSpacer($userSettings, $detectedSettings, $defaultSettings);

        $stylePalette =
            $this->getStylePalette($userSettings, $detectedSettings, $defaultSettings);

        $charPalette =
            $this->getCharPalette($userSettings, $detectedSettings, $defaultSettings);

        return new RootWidgetSettings(
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            stylePalette: $stylePalette,
            charPalette: $charPalette,
        );
    }

    private function getLeadingSpacer(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): ?IFrame {
        return $userSettings?->getLeadingSpacer()
            ??
            $detectedSettings?->getLeadingSpacer()
            ??
            $defaultSettings?->getLeadingSpacer();
    }

    private function getTrailingSpacer(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): ?IFrame {
        return $userSettings?->getTrailingSpacer()
            ??
            $detectedSettings?->getTrailingSpacer()
            ??
            $defaultSettings?->getTrailingSpacer();
    }

    private function getStylePalette(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): ?IStylePalette {
        return $userSettings?->getStylePalette()
            ??
            $detectedSettings?->getStylePalette()
            ??
            $defaultSettings?->getStylePalette();
    }

    private function getCharPalette(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): ?ICharPalette {
        return $userSettings?->getCharPalette()
            ??
            $detectedSettings?->getCharPalette()
            ??
            $defaultSettings?->getCharPalette();
    }

    protected function extractSettings(ISettings $settings): ?IRootWidgetSettings
    {
        return $this->extractSettingsElement($settings, IRootWidgetSettings::class);
    }
}
