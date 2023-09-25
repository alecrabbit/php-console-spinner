<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;

abstract class APalette implements IPalette
{
    abstract public function getEntries(?IPaletteOptions $options = null): \Traversable;
}
