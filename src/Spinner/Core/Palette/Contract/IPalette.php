<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IPalette
{
    public function getEntries(?IPaletteOptions $options = null): \Traversable;
}
