<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IPalette
{
    public function getEntries(?IPaletteMode $entriesMode = null): \Traversable;

    public function getOptions(): IPaletteOptions;
}
