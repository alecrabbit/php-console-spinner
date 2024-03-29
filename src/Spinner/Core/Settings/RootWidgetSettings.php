<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;

final readonly class RootWidgetSettings implements IRootWidgetSettings
{
    public function __construct(
        private ?IFrame $leadingSpacer = null,
        private ?IFrame $trailingSpacer = null,
        private ?IPalette $stylePalette = null,
        private ?IPalette $charPalette = null,
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

    public function getStylePalette(): ?IPalette
    {
        return $this->stylePalette;
    }

    public function getCharPalette(): ?IPalette
    {
        return $this->charPalette;
    }

    public function getIdentifier(): string
    {
        return IRootWidgetSettings::class;
    }
}
