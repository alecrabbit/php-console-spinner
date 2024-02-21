<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePaletteRenderer;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;

final readonly class ModePaletteRenderer implements IModePaletteRenderer
{

    public function __construct(
        private IPaletteModeFactory $paletteModeFactory,
    ) {
    }

    public function render(IModePalette $palette): IPalette
    {
        $mode = $this->paletteModeFactory->create();

        $frames = new \ArrayObject(
            iterator_to_array($palette->getEntries($mode)),
        );

        $options = $palette->getOptions($mode);

        if ($palette instanceof IStylePalette) {
            return new class($frames, $options) extends AStylePalette {
            };
        }

        return new class($frames, $options) extends ACharPalette {
        };
    }
}
