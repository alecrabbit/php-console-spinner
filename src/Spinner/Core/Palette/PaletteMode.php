<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;

final readonly class PaletteMode implements IPaletteMode
{
    public function __construct(
        protected StylingMode $stylingMode,
    ) {
    }

    public function getStylingMode(): StylingMode
    {
        return $this->stylingMode;
    }
}
