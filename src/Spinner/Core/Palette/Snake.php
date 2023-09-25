<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;

final class Snake extends APalette implements ICharPalette
{
    public function getEntries(?IPaletteOptions $options = null): \Traversable
    {
        yield from [
            new CharFrame('⠏', 1),
            new CharFrame('⠛', 1),
            new CharFrame('⠹', 1),
            new CharFrame('⢸', 1),
            new CharFrame('⣰', 1),
            new CharFrame('⣤', 1),
            new CharFrame('⣆', 1),
            new CharFrame('⡇', 1),
        ];
    }
}
