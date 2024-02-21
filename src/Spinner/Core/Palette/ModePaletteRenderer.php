<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePaletteRenderer;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
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
            return new class($frames, $options) implements IStylePalette {
                private int $count;

                public function __construct(
                    private readonly \ArrayObject $frames,
                    private readonly IPaletteOptions $options,
                    private int $index = 0,
                ) {
                    $this->count = $this->frames->count();
                }

                public function getFrame(?float $dt = null): IStyleSequenceFrame
                {
                    if ($this->count === 1 || ++$this->index === $this->count) {
                        $this->index = 0;
                    }

                    return $this->frames->offsetGet($this->index);
                }

                public function getOptions(): IPaletteOptions
                {
                    return $this->options;
                }
            };
        }

        return new NoCharPalette();
    }
}
