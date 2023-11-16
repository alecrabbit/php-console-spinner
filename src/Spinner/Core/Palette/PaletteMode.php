<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;

final readonly class PaletteMode implements IPaletteMode
{
    public function __construct(
        protected StylingMethodMode $stylingMode,
    ) {
    }

    public function getStylingMode(): StylingMethodMode
    {
        return $this->stylingMode;
    }
}
