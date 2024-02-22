<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use ArrayObject;

final class CustomStylePalette extends AStylePalette
{
    public function __construct(
        ArrayObject $frames,
        IPaletteOptions $options = new PaletteOptions(),
        int $index = 0,
    ) {
        parent::__construct($frames, $options, $index);
    }
}
