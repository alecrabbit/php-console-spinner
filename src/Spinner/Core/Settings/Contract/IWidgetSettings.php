<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface IWidgetSettings extends ISettingsElement
{
    public function setTrailingSpacer(?IFrame $trailingSpacer): void;

    public function getLeadingSpacer(): ?IFrame;

    public function getTrailingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): void;

    public function getStylePalette(): ?IPalette;

    public function setStylePalette(?IPalette $stylePalette): void;

    public function getCharPalette(): ?IPalette;

    public function setCharPalette(?IPalette $charPalette): void;
}
