<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\CharFrame;

final class NoCharPalette extends APalette implements ICharPalette
{
    public function getEntries(?IPaletteOptions $options = null): \Traversable
    {
        yield from [
            new CharFrame('', 0),
        ];
    }
}
