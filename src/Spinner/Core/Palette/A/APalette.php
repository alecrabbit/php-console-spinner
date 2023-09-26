<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;

abstract class APalette implements IPalette
{
    public function __construct(
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    abstract public function getEntries(?IPaletteMode $entriesMode = null): \Traversable;

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
