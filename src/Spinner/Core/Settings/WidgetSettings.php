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

    /**
     * @return class-string<IWidgetSettings>
     */
    public function getIdentifier(): string
    {
        return IWidgetSettings::class;
    }
}
