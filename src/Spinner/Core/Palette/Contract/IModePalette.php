<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IModePalette extends IPalette
{
    public function getEntries(?IPaletteMode $mode = null): \Traversable;
}
