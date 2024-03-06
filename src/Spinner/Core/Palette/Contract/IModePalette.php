<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use Traversable;

interface IModePalette extends IPalette
{
    public function getEntries(?IPaletteMode $mode = null): Traversable;

    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions;
}
