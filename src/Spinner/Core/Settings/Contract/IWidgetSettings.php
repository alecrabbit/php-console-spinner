<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface IWidgetSettings extends ISettingsElement
{
    public function getLeadingSpacer(): ?IFrame;

    public function getTrailingSpacer(): ?IFrame;

    public function getStylePalette(): ?IPalette;

    public function getCharPalette(): ?IPalette;
}
