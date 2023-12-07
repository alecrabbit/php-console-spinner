<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;

final readonly class WidgetSettingsSolver extends ASolver implements IWidgetSettingsSolver
{
    public function solve(): IWidgetSettings
    {
        return $this->doSolve(
            $this->extractSettings($this->settingsProvider->getUserSettings()),
            $this->extractSettings($this->settingsProvider->getDetectedSettings()),
            $this->extractSettings($this->settingsProvider->getDefaultSettings()),
        );
    }

    /**
     * @throws LogicException
     */
    private function doSolve(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings,
    ): IWidgetSettings {
        $leadingSpacer =
            $this->getLeadingSpacer($userSettings, $detectedSettings, $defaultSettings);

        $trailingSpacer =
            $this->getTrailingSpacer($userSettings, $detectedSettings, $defaultSettings);

        $stylePalette =
            $this->getStylePalette($userSettings, $detectedSettings, $defaultSettings);

        $charPalette =
            $this->getCharPalette($userSettings, $detectedSettings, $defaultSettings);

        return new WidgetSettings(
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
    ): IFrame {
        return $userSettings?->getLeadingSpacer()
            ??
            $detectedSettings?->getLeadingSpacer()
            ??
            $defaultSettings?->getLeadingSpacer()
            ??
            throw new LogicException('Leading spacer expected to be set.');
    }

    private function getTrailingSpacer(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): IFrame {
        return $userSettings?->getTrailingSpacer()
            ??
            $detectedSettings?->getTrailingSpacer()
            ??
            $defaultSettings?->getTrailingSpacer()
            ??
            throw new LogicException('Trailing spacer expected to be set.');
    }

    private function getStylePalette(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): IStylePalette {
        return $userSettings?->getStylePalette()
            ??
            $detectedSettings?->getStylePalette()
            ??
            $defaultSettings?->getStylePalette()
            ??
            throw new LogicException('Style palette expected to be set.');
    }

    private function getCharPalette(
        ?IWidgetSettings $userSettings,
        ?IWidgetSettings $detectedSettings,
        ?IWidgetSettings $defaultSettings
    ): ICharPalette {
        return $userSettings?->getCharPalette()
            ??
            $detectedSettings?->getCharPalette()
            ??
            $defaultSettings?->getCharPalette()
            ??
            throw new LogicException('Char palette expected to be set.');
    }

    protected function extractSettings(ISettings $settings): ?IWidgetSettings
    {
        return $this->extractSettingsElement($settings, IWidgetSettings::class);
    }
}
