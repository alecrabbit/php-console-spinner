<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final readonly class WidgetSettings implements IWidgetSettings
{
    public function __construct(
        private ?IFrame $leadingSpacer = null,
        private ?IFrame $trailingSpacer = null,
        private ?IStylePalette $stylePalette = null,
        private ?ICharPalette $charPalette = null,
    ) {
    }

    public function getLeadingSpacer(): ?IFrame
    {
        return $this->leadingSpacer;
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    public function getStylePalette(): ?IStylePalette
    {
        return $this->stylePalette;
    }

    public function getCharPalette(): ?ICharPalette
    {
        return $this->charPalette;
    }

    /**
     * @return class-string<IWidgetSettings>
     */
    public function getIdentifier(): string
    {
        return IWidgetSettings::class;
    }
}
