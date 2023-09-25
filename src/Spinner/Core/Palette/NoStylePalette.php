<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\StyleFrame;

final class NoStylePalette extends APalette implements IStylePalette
{
    public function getEntries(?IPaletteOptions $options = null): \Traversable
    {
        yield from [
            new StyleFrame('%s', 0),
        ];
    }
}
