<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final class WidgetSettings implements IWidgetSettings
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

    /** @deprecated */
    public function setLeadingSpacer(?IFrame $leadingSpacer): void
    {
        $this->leadingSpacer = $leadingSpacer;
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    /** @deprecated */
    public function setTrailingSpacer(?IFrame $trailingSpacer): void
    {
        $this->trailingSpacer = $trailingSpacer;
    }

    public function getStylePalette(): ?IPalette
    {
        return $this->stylePalette;
    }

    /** @deprecated */
    public function setStylePalette(?IPalette $stylePalette): void
    {
        $this->stylePalette = $stylePalette;
    }

    public function getCharPalette(): ?IPalette
    {
        return $this->charPalette;
    }

    /** @deprecated */
    public function setCharPalette(?IPalette $charPalette): void
    {
        $this->charPalette = $charPalette;
    }

    /**
     * @return class-string<IWidgetSettings>
     */
    public function getIdentifier(): string
    {
        return IWidgetSettings::class;
    }
}
