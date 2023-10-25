<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface IWidgetSettings extends ISettingsElement
{
    /** @deprecated */
    public function setTrailingSpacer(?IFrame $trailingSpacer): void;

    public function getLeadingSpacer(): ?IFrame;

    public function getTrailingSpacer(): ?IFrame;

    /** @deprecated */
    public function setLeadingSpacer(?IFrame $leadingSpacer): void;

    public function getStylePalette(): ?IPalette;

    /** @deprecated */
    public function setStylePalette(?IPalette $stylePalette): void;

    public function getCharPalette(): ?IPalette;

    /** @deprecated */
    public function setCharPalette(?IPalette $charPalette): void;
}
