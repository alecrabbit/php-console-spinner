<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use Traversable;

abstract class APalette implements IPalette
{
    public function __construct(
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    /** @inheritDoc */
    abstract public function getEntries(?IPaletteMode $mode = null): Traversable;

    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        return $this->options;
    }
}
