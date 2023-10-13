<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use Traversable;

abstract class APalette implements IPalette
{
    public function __construct(
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    public function getTemplate(?IPaletteMode $mode = null): IPaletteTemplate
    {
        $options = $this->getOptions($mode);

        return
            new PaletteTemplate(
                $this->getEntries($mode),
                $options,
            );
    }

    protected function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        return $this->options;
    }

    abstract protected function getEntries(?IPaletteMode $mode = null): Traversable;
}