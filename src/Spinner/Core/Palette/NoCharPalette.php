<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

final class NoCharPalette extends APalette implements ICharPalette
{
    protected function getEntries(?IPaletteMode $mode = null): Traversable
    {
        yield from [
            new CharFrame('', 0),
        ];
    }
}
