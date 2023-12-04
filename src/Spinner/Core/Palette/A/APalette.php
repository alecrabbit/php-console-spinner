<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Contract\IFrame;
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

    // FIXME (2023-12-04 16:9) [Alec Rabbit]: extract functionality to PaletteTemplateFactory->create($palette)
    public function getTemplate(?IPaletteMode $mode = null): IPaletteTemplate
    {
        return new PaletteTemplate(
            $this->getEntries($mode),
            $this->getOptions($mode),
        );
    }

    /**
     * @return Traversable<IFrame>
     */
    abstract protected function getEntries(?IPaletteMode $mode = null): Traversable;

    protected function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        return $this->options;
    }
}
