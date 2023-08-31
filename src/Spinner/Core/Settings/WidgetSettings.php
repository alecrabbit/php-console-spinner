<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

final class WidgetSettings implements Contract\IWidgetSettings
{
    public function __construct(
        protected ?IFrame $leadingSpacer = null,
        protected ?IFrame $trailingSpacer = null,
        protected ?IPalette $stylePalette = null,
        protected ?IPalette $charPalette = null,
    ) {
    }

    public function getLeadingSpacer(): ?IFrame
    {
        return $this->leadingSpacer;
    }

    public function setLeadingSpacer(?IFrame $leadingSpacer): void
    {
        $this->leadingSpacer = $leadingSpacer;
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    public function setTrailingSpacer(?IFrame $trailingSpacer): void
    {
        $this->trailingSpacer = $trailingSpacer;
    }

    public function getStylePalette(): ?IPalette
    {
        return $this->stylePalette;
    }

    public function setStylePalette(?IPalette $stylePalette): void
    {
        $this->stylePalette = $stylePalette;
    }

    public function getCharPalette(): ?IPalette
    {
        return $this->charPalette;
    }

    public function setCharPalette(?IPalette $charPalette): void
    {
        $this->charPalette = $charPalette;
    }
}
