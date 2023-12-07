<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Factory;

use AlecRabbit\Spinner\Core\Palette\Builder\Contract\IPaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteTemplateFactory;

final readonly class PaletteTemplateFactory implements IPaletteTemplateFactory
{
    public function __construct(
        private IPaletteTemplateBuilder $builder,
        private IPaletteModeFactory $paletteModeFactory,
    ) {
    }

    public function create(IPalette $palette): IPaletteTemplate
    {
        $mode = $this->paletteModeFactory->create();

        return $this->builder
            ->withEntries($palette->getEntries($mode))
            ->withOptions($palette->getOptions($mode))
            ->build()
        ;
    }
}
