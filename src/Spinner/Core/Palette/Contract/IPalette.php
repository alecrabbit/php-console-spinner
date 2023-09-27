<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use Traversable;

interface IPalette
{
    public function getEntries(?IPaletteMode $entriesMode = null): Traversable;

    public function getOptions(): IPaletteOptions;
}
