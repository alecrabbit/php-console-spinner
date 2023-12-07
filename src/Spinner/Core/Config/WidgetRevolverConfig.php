<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;

final readonly class WidgetRevolverConfig implements IWidgetRevolverConfig
{
    public function __construct(
        protected IStylePalette $stylePalette,
        protected ICharPalette $charPalette,
        protected IRevolverConfig $revolverConfig,
    ) {
    }

    public function getStylePalette(): IStylePalette
    {
        return $this->stylePalette;
    }

    public function getCharPalette(): ICharPalette
    {
        return $this->charPalette;
    }

    public function getRevolverConfig(): IRevolverConfig
    {
        return $this->revolverConfig;
    }
}
