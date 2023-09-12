<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

final readonly class WidgetRevolverConfig implements IWidgetRevolverConfig
{
    public function __construct(
        protected IPalette $stylePalette,
        protected IPalette $charPalette,
    ) {
    }

    public function getStylePalette(): IPalette
    {
        return $this->stylePalette;
    }

    public function getCharPalette(): IPalette
    {
        return $this->charPalette;
    }
}
