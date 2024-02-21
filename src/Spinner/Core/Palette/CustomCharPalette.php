<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;

final class CustomCharPalette extends ACharPalette
{
    public function __construct(
        \ArrayObject $frames,
        IPaletteOptions $options = new PaletteOptions(),
        int $index = 0,
    ) {
        parent::__construct($frames, $options, $index);
    }
}
