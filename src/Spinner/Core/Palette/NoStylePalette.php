<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

final class NoStylePalette extends APalette implements IStylePalette
{
    public function getEntries(?IPaletteMode $entriesMode = null): Traversable
    {
        yield from [
            new StyleFrame('%s', 0),
        ];
    }
}
